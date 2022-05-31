<?php

namespace Drupal\offer\Controller;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Url;
use Drupal\offer\Entity\Offer;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class OfferExpiredController.php
 */
class OfferExpiredController extends ControllerBase {

  public function Render(Offer $offer) {

    // We set the moderation to expired
    $new_state = 'expired';
    $offer->set('moderation_state', $new_state);
    if ($offer instanceof RevisionLogInterface) {
      $offer->setRevisionLogMessage('Changed moderation state to Expired.');
      $offer->setRevisionUserId($this->currentUser()->id());
    }
    $offer->save();

    $publishedOffer = Url::fromRoute('entity.offer.canonical', ['offer' => $offer->id()]);

    \Drupal::messenger()->addMessage($offer->label() . ' is set to expired.');

    return new RedirectResponse($publishedOffer->toString());

  }

  public function Access(Offer $offer) {

    // Securing no one is trying to publish other people's offers.
    $access = AccessResult::allowedIf($offer->access('view'));
    // Make sure state is published
    if($offer->get('moderation_state')->getString() != 'published') {
      $access = AccessResult::forbidden();
    }

    return $access;
  }

}
