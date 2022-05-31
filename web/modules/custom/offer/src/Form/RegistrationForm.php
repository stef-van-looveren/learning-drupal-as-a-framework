<?php

namespace Drupal\offer\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\user\Entity\User;
use Drupal\Component\Utility\Xss;

class RegistrationForm extends FormBase {

  /**
   * @return string
   *   The unique string identifying the form.
   */
  public function getFormId() {
    return 'offer_registration_form';
  }

  /**
   * Form constructor.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   * @param \Drupal\offer\Entity\Offer $offer
   *   The offer entity we're viewing
   *
   * @return array
   *   The form structure.
   */
  public function buildForm(array $form, FormStateInterface $form_state, $offer = NULL) {

    $form['email'] = [
      '#type' => 'email',
      '#attributes' => array(
        ' type' => 'email', // note the space before attribute name
      ),
      '#title' => $this->t('Your email address'),
      '#required' => TRUE,
    ];

    $form['username'] = [
      '#type' => 'textfield',
      '#attributes' => array(
        ' minlength' => 2, // note the space before attribute name
      ),
      '#title' => $this->t('Your name'),
      '#required' => TRUE,
    ];

    $form['password'] = [
      '#type' => 'password',
      '#attributes' => array(
        ' type' => 'password', // note the space before attribute name
        ' minlength' => 8
      ),
      '#title' => $this->t('Your password'),
      '#description' => $this->t('Should be minimum 8 characters.'),
      '#required' => TRUE,
    ];

    // Group submit handlers in an actions element with a key of "actions" so
    // that it gets styled correctly, and so that other modules may add actions
    // to the form. This is not required, but is convention.
    $form['actions'] = [
      '#type' => 'actions',
    ];

    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Register'),
    ];

    return $form;

  }

  /**
   * Validate the input values of the form
   *
   * @param array $form
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *
   */
  public function validateForm(array &$form, FormStateInterface $form_state)
  {
    parent::validateForm($form, $form_state);
    // Server side validation for email
    if (!\Drupal::service('email.validator')->isValid($form_state->getValues()['email'])) {
      $form_state->setErrorByName('Email', $this->t('Email address is not a valid.'));
    }

    // Check if username exists
    $user_exists = user_load_by_name(Xss::filter($form_state->getValues()['username']));
    if(!empty($user_exists)) {
      $form_state->setErrorByName('username', $this->t('An account with this username already exists.'));
    }

    // Check if email exists
    $ids = \Drupal::entityQuery('user')
      ->condition('mail', Xss::filter($form_state->getValues()['email']))
      ->range(0, 1)
      ->execute();
    if(!empty($ids)){
      $form_state->setErrorByName('email', $this->t('An account with this email address already exists.'));
    }

    // check if pass = minimum 8 characters server-side
    if(strlen($form_state->getValues()['password']) < 8) {
      $form_state->setErrorByName('password', $this->t('Minimum length of password needs to be 8 characters.'));
    }

  }

  /**
   * Form submission handler.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $user = User::create();
    $user->enforceIsNew();
    $user->setEmail($form_state->getValues()['email']);
    $user->setUsername($form_state->getValues()['email']); //This username must be unique and accept only a-Z,0-9, - _ @ .
    $user->setPassword(Xss::filter($form_state->getValues()['password']));
    $user->activate();
    $user->save();
    user_login_finalize($user); // logs a new session etc.
    // This will redirect with StackMiddleware
  }

}
