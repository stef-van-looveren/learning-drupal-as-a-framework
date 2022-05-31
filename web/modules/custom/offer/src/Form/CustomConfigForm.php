<?php

namespace Drupal\offer\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class CustomConfigForm.
 */
class CustomConfigForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'offer.customconfig',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'custom_config_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('offer.customconfig');

    $form['analytics'] = array(
      '#type' => 'details',
      '#title' => $this->t('Marketing & analytics'),
      '#open' => TRUE,
    );
    $form['analytics']['tagmanager'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Tagmanager code'),
      '#default_value' => $config->get('tagmanager'),
      '#maxlength' => NULL,
    ];

    $form['content'] = array(
      '#type' => 'details',
      '#title' => $this->t('Content'),
      '#open' => TRUE,
    );
    $form['content']['about'] = [
      '#type' => 'text_format',
      '#title' => $this->t('About page'),
      '#default_value' => $config->get('about'),
      '#maxlength' => NULL,
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('offer.customconfig')
      ->set('tagmanager', $form_state->getValue('tagmanager'))
      ->set('about', $form_state->getValue('about')['value'])
      ->save();
  }

}
