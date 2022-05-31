<?php

namespace Drupal\notification;

use Drupal\views\EntityViewsData;

/**
 * Provides views data for Notification entities.
 *
 */
class NotificationViewsData extends EntityViewsData {

  /**
   * Returns the Views data for the entity.
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    $data['notification']['notification_message'] = [
      'title' => t('Notification'),
      'field' => array(
        'title' => t('Notification message'),
        'help' => t('Shows the message based on type'),
        'id' => 'notification_message',
      ),
    ];


    return $data;
  }
}
