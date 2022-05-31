<?php
/**
 * @file
 * Contains Drupal\offer\Form\OfferForm.
 */

namespace Drupal\offer\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for the offer entity edit forms.
 *
 * @ingroup content_entity_example
 */
class OfferAddFormStep2 extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /* @var $entity \Drupal\offer\Entity\Offer */
    $form = parent::buildForm($form, $form_state);
    $form['actions']['submit']['#value'] = t('Save and proceed');
    return $form;
  }

  protected function actions(array $form, FormStateInterface $form_state) {
    $actions =  parent::actions($form, $form_state);
    $actions['go_back'] = [
      '#type' => 'submit',
      '#value' => $this->t('Back to step 1'),
      '#submit' => ['::goBack'],
      '#weight' => 90,
      '#limit_validation_errors' => []
    ];
    if (array_key_exists('delete', $actions)) {
      unset($actions['delete']);
    }
    $actions['#prefix'] = '<i>Step 2 of 3</i>';
    return $actions;
  }

  public function goBack(array $form, FormStateInterface $form_state) {
    $entity = $this->getEntity();
    $id = $entity->id();
    $form_state->setRedirect('offer.step1', ['offer' => $id]);
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    // Redirect to step 3
    $entity = $this->getEntity();
    $entity->save();
    $id = $entity->id();
    $form_state->setRedirect('offer.step3', ['offer' => $id]);
  }

}
