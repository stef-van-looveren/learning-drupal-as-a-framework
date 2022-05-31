<?php
namespace Drupal\notification\Plugin\Menu;

use Drupal\Core\Menu\MenuLinkDefault;

/**
 * displays number of notifications.
 */
class MyNotifications extends MenuLinkDefault {

  /**
   * {@inheritdoc}
   */
  public function getTitle() {
    $count = 0;
    if(\Drupal::currentUser()->isAuthenticated()) {
      $notifications = \Drupal::entityTypeManager()
        ->getStorage('notification')
        ->loadByProperties(['user_id' => \Drupal::currentUser()->id()]);
      $count = count($notifications);
      return $this->t('Notifications (<span class="badge">@count</span>)', ['@count' => $count]);
    } else {
      return null;
    }
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheMaxAge() {
    return 0;
  }

}
