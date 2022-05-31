<?php

namespace Drupal\notification;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Access controller for the notification entity. Controls create/edit/delete access for entity and fields.
 *
 * @see \Drupal\notification\Entity\Notification.
 */
class NotificationAccessControlHandler extends EntityAccessControlHandler {

  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    $access = AccessResult::forbidden();
    switch ($operation) {
      case 'view':
        $access = AccessResult::allowedIf($account->id() == $entity->getOwnerId())->cachePerUser()->addCacheableDependency($entity);
        break;
      case 'update':
          $access = AccessResult::allowedIf($account->id() == $entity->getOwnerId())->cachePerUser()->addCacheableDependency($entity);
        break;
      case 'edit':
          $access = AccessResult::allowedIf($account->id() == $entity->getOwnerId())->cachePerUser()->addCacheableDependency($entity);
        break;
      case 'delete':
          $access = AccessResult::allowedIf($account->id() == $entity->getOwnerId())->cachePerUser()->addCacheableDependency($entity);
        break;
    }

    return $access;
  }
}

?>
