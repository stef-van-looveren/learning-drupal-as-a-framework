<?php

namespace Drupal\offer;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Access controller for the offer entity. Controls create/edit/delete access for entity and fields.
 *
 * @see \Drupal\offer\Entity\Offer.
 */
class OfferAccessControlHandler extends EntityAccessControlHandler
{

  /**
   * {@inheritdoc}
   *
   * Link the activities to the permissions. checkAccess is called with the
   * $operation as defined in the routing.yml file.
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account)
  {

    $access = AccessResult::forbidden();

    switch ($operation) {
      case 'view':
        // draft
        if($entity->get('moderation_state')->getString() == 'draft') {
          if ($account->hasPermission('administer own offers')) {
            $access = AccessResult::allowedIf($account->id() == $entity->getOwnerId())->cachePerUser()->addCacheableDependency($entity);
          }
        } else {
          // published, expired
          $access = AccessResult::allowed()->addCacheableDependency($entity);
        }
        break;
      case 'update': // Shows the edit buttons in operations
        if ($account->hasPermission('administer own offers')) {
          $access = AccessResult::allowedIf($account->id() == $entity->getOwnerId())->cachePerUser()->addCacheableDependency($entity);
        }
        break;
      case 'edit': // Lets me in on the edit-page of the entity
        if ($account->hasPermission('administer own offers')) {
          $access = AccessResult::allowedIf($account->id() == $entity->getOwnerId())->cachePerUser()->addCacheableDependency($entity);
        }
        break;
      case 'delete': // Shows the delete buttons + access to delete this entity
        if ($account->hasPermission('administer own offers')) {
          $access = AccessResult::allowedIf($account->id() == $entity->getOwnerId())->cachePerUser()->addCacheableDependency($entity);
        }
        break;
    }

    return $access;
  }

  /**
   * {@inheritdoc}
   *
   * Separate from the checkAccess because the entity does not yet exist, it
   * will be created during the 'add' process.
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL)
  {
    return AccessResult::allowedIfHasPermission($account, 'administer own offers');
  }
}
