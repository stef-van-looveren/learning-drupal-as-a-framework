<?php
/**
 * @file
 * Contains Drupal\offer\Form\OfferForm.
 */

namespace Drupal\offer\Form;

use Drupal\Core\Cache\Cache;
use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for the offer entity edit forms.
 *
 * @ingroup content_entity_example
 */
class OfferAddFormStep1 extends ContentEntityForm {

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
    $actions['cancel'] = [
      '#type' => 'submit',
      '#value' => $this->t('Cancel'),
      '#submit' => ['::cancelSubmit'],
      '#weight' => 90,
      '#limit_validation_errors' => []
    ];
    if (array_key_exists('delete', $actions)) {
      unset($actions['delete']);
    }
    $actions['#prefix'] = '<i>Step 1 of 3</i>';

    return $actions;
  }

  public function cancelSubmit(array $form, FormStateInterface $form_state) {
    $form_state->setRedirect('entity.offer.collection');
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    // Redirect to step 2
    $entity = $this->getEntity();
    $entity->save();
    Cache::invalidateTags(['my_offers_user_' . $entity->getOwnerId()]);
    $id = $entity->id();
    $form_state->setRedirect('offer.step2', ['offer' => $id]);
  }

}
