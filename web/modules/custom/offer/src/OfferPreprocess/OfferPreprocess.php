<?php

namespace Drupal\offer\OfferPreprocess;

use Drupal\bid\Entity\Bid;
use Drupal\offer\Entity\Offer;
use Drupal\Core\Render\Markup;
use Drupal\Core\Link;

class OfferPreprocess {

  /**
   * Returns rendered table below an offer
   * @param entity $offer
   *  The offer entity
   * @return array $table
   *  Drupal table render array
   */
  public static function offerTable(Offer $offer) {
    $bids = $offer->getOfferBids();

    $rows = [];
    foreach($bids as $bid) {
      $price = $bid->get('bid')->getString();
      $owner = $bid->getOwner();
      $ownerId = $bid->getOwnerId();
      $ownerName = $owner->getDisplayName();

      // Render the 'compact' user profile
      $entity_type = 'user';
      $entity_id = $ownerId;
      $view_mode = 'compact';
      $entity = \Drupal::entityTypeManager()->getStorage($entity_type)->load($entity_id);
      $view_builder = \Drupal::entityTypeManager()->getViewBuilder($entity_type);
      $user_to_render = $view_builder->view($entity, $view_mode);

      $time = \Drupal::service('date.formatter')->formatTimeDiffSince($bid->created->value);

      $updates = '';
      $link = '';
      if($bid->hasRevisions()) {
        $revisions = $bid->getRevisionsList();
        // We now have the list of revisions.
        // Let's compare the latest bid with the last revision
        $current_revision_id = $bid->getLoadedRevisionId();
        // We now know the current, we want the one before the current
        // We remove the current from the revisions list
        unset($revisions[$current_revision_id]);
        // And take the last one from the revisions list
        $last_revision_id = max(array_keys($revisions));
        $revisionBid = \Drupal::entityTypeManager()
          ->getStorage('bid')
          ->loadRevision($last_revision_id);
        $revisionAmount = $revisionBid->get('bid')->getString();
        $priceDifference = $price - $revisionAmount;
        $updates = '<svg width="24px" height="18px" viewBox="0 0 24 24" fill="#61f70a" xmlns="http://www.w3.org/2000/svg">
        <path d="M6.1018 16.9814C5.02785 16.9814 4.45387 15.7165 5.16108 14.9083L10.6829 8.59762C11.3801 7.80079 12.6197 7.80079 13.3169 8.59762L18.8388 14.9083C19.5459 15.7165 18.972 16.9814 17.898 16.9814H6.1018Z" fill="#61f70a"/>
        </svg><small style="color:#0444C4">Last raise was ' . $priceDifference .'$</small>';
      }
      if($bid->access('delete')) {
        $url = $bid->toUrl('delete-form');
        $deleteLink = [
          '#type' => 'link',
          '#title' => 'Remove bid',
          '#url' => $url,
          '#attributes' => [
            'class' => ['use-ajax', 'button--small', 'button', 'button--danger'],
            'data-dialog-type' => 'modal',
            'data-dialog-options' => \Drupal\Component\Serialization\Json::encode(['title' => t('Remove bid?'), 'width' => 800,]),
          ],
        ];
        $link = render($deleteLink);
      }

      $row = [
        Markup::create( render($user_to_render)),
        Markup::create('<small>'. $time . ' ago</small>'),
        Markup::create('<span class="bid-price">'. $price . '$</span>'  . $updates),
        Markup::create($link)
      ];
      $rows[] = $row;
    }

    $build['table'] = [
      '#type' => 'table',
      '#rows' => $rows,
      '#empty' => t('This offer has no bids yet. Grab your chance!'),
    ];
    return [
      '#type' => '#markup',
      '#markup' => render($build)
    ];
  }

}
