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
class OfferAddFormStep3 extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /* @var $entity \Drupal\offer\Entity\Offer */
    $form = parent::buildForm($form, $form_state);
    $form['actions']['submit']['#value'] = t('Save and proceed');

    $form['field_price']['#states'] = [
      'visible' => [
        ['select[name="field_offer_type"]' => ['value' => 'with_minimum']],
      ]
    ];

    return $form;
  }

  protected function actions(array $form, FormStateInterface $form_state) {
    $actions =  parent::actions($form, $form_state);
    $actions['go_back'] = [
      '#type' => 'submit',
      '#value' => $this->t('Back to step 2'),
      '#submit' => ['::goBack'],
      '#weight' => 90,
      '#limit_validation_errors' => []
    ];
    if (array_key_exists('delete', $actions)) {
      unset($actions['delete']);
    }
    $actions['#prefix'] = '<i>Step 3 of 3</i>';
    return $actions;
  }

  public function goBack(array $form, FormStateInterface $form_state) {
    $entity = $this->getEntity();
    $id = $entity->id();
    $form_state->setRedirect('offer.step2', ['offer' => $id]);
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    // Redirect to offer overview after save
    \Drupal::messenger()->addMessage('Your offer was created. Click the publish button to start earning!');
    $entity = $this->getEntity();
    $entity->save();
    $form_state->setRedirect('entity.offer.collection');
  }

}
