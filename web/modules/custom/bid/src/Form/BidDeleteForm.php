<?php

/**
 * @file
 * Contains \Drupal\bid\Form\BidDeleteForm.
 */

namespace Drupal\bid\Form;

use Drupal\Core\Entity\ContentEntityConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\offer\Entity\Offer;

/**
 * Provides a form for deleting a content_entity_example entity.
 *
 * @ingroup bid
 */
class BidDeleteForm extends ContentEntityConfirmFormBase {

  /**
   * {@inheritdoc}
   */
  public function getQuestion() {
    return $this->t('Are you sure you want to delete your bid of %price$?', array('%price' => $this->entity->get('bid')->getString()));
  }

  /**
   * {@inheritdoc}
   *
   * If the delete command is canceled, return to the bid list.
   */
  public function getCancelUrl() {
    $offer_id = $this->entity->get('offer_id')->getString();
    $url = new Url('entity.offer.canonical', ['offer' => $offer_id]);
    return $url;
  }

  /**
   * {@inheritdoc}
   */
  public function getConfirmText() {
    return $this->t('Delete');
  }

  /**
   * {@inheritdoc}
   *
   * Delete the entity and log the event. logger() replaces the watchdog.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Redirect to offer after delete.
    $offer_id = $this->entity->get('offer_id')->getString();

    $entity = $this->getEntity();
    $entity->delete();

    $this->logger('bid')->notice('deleted bid %id.',
      array(
        '%title' => $this->entity->id(),
      ));
    $form_state->setRedirect('entity.offer.canonical', ['offer' => $offer_id]);
  }

}
