<?php

namespace Drupal\offer;

use Drupal\views\EntityViewsData;

/**
 * Provides views data for Offer entities.
 *
 */
class OfferViewsData extends EntityViewsData {

  /**
   * Returns the Views data for the entity.
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    $data['offer']['offer_entity_moderation_state_views_field'] = [
      'title' => t('Moderation status'),
      'field' => [
        'title' => t('Moderation status'),
        'help' => t('Shows the status of the offer entity'),
        'id' => 'offer_entity_moderation_state_views_field'
      ]
    ];

    $data['offer']['offer_dynamic_option_links'] = [
      'title' => t('Dynamic operations'),
      'field' => [
        'title' => t('Dynamic operations'),
        'help' => t('Shows a dropbutton with dynamic operations for offers.'),
        'id' => 'offer_dynamic_operation_links',
      ]
    ];

    return $data;
  }
}
