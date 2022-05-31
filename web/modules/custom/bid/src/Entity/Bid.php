<?php
/**
 * @file
 * Contains \Drupal\bid\Entity\bid.
 */

namespace Drupal\bid\Entity;

use Drupal\Core\Cache\Cache;
use Drupal\Core\Entity\EditorialContentEntityBase;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\offer\Entity\Offer;

/**
 * Defines the bid entity.
 *
 * @ingroup bid
 *
 * @ContentEntityType(
 *   id = "bid",
 *   label = @Translation("bid"),
 *   base_table = "bid",
 *   data_table = "bid_field_data",
 *   fieldable = FALSE,
 *   revision_table = "bid_revision",
 *   revision_data_table = "bid_field_revision",
 *   entity_keys = {
 *     "id" = "id",
 *     "uuid" = "uuid",
 *     "label" = "title",
 *     "owner" = "uid",
 *     "revision" = "vid",
 *     "published" = "status",
 *     "uid" = "uid",
 *     "owner" = "uid",
 *   },
 *   handlers = {
 *     "access" = "Drupal\bid\BidAccessControlHandler",
 *     "form" = {
 *       "delete" = "Drupal\bid\Form\BidDeleteForm",
 *     },
 *   },
 *   links = {
 *     "delete-form" = "/bid/{bid}/delete",
 *   },
 *   revision_metadata_keys = {
 *     "revision_user" = "revision_uid",
 *     "revision_created" = "revision_timestamp",
 *     "revision_log_message" = "revision_log"
 *   },
 *   constraints = {
 *    "AllFieldsRequired" = {}
 *   }
 * )
 */

class Bid extends EditorialContentEntityBase {

  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type); // provides id and uuid fields

    $fields['user_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('User'))
      ->setDescription(t('The user that created the bid.'))
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default');

    $fields['offer_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Offer'))
      ->setDescription(t('The offer the bid is for.'))
      ->setSetting('target_type', 'offer')
      ->setSetting('handler', 'default');

    $fields['bid'] = BaseFieldDefinition::create('float')
      ->setLabel(t('Bid amount'))
      ->setRevisionable(TRUE)
      ->setDescription(t('The bid amount in $.'));

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    return $fields;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwner() {
    return $this->get('user_id')->entity;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwnerId() {
    return $this->get('user_id')->target_id;
  }

  /**
   * Checks if the bid has revisions
   * @return bool
   *  True if it has, false if it does not
   */
  public function hasRevisions() {
    $id = $this->id();
    $query = \Drupal::entityQuery('bid')
      ->condition('id', $id);
    $count = $query->allRevisions()->count()->execute();
    if($count > 1) {
      return TRUE;
    } else {
      return FALSE;
    }
  }

  /**
   * Returns list of revision entity ids of the bid. Key is the revision ID.
   * @return array
   */
  public function getRevisionsList() {
    $id = $this->id();
    $query = \Drupal::entityQuery('bid')
      ->condition('id', $id);
    $revisions = $query->allRevisions()->execute();
    return $revisions;
  }

  /**
   * {@inheritdoc}
   */
  public function postSave(EntityStorageInterface $storage, $update = TRUE) {
    $this->invalidateTagsOnSave($update);
    $offer = Offer::load($this->get('offer_id')->target_id);
    Cache::invalidateTags($offer->getCacheTagsToInvalidate());
  }

  /**
   * {@inheritdoc}
   */
  public static function postDelete(EntityStorageInterface $storage, array $entities) {
    static::invalidateTagsOnDelete($storage->getEntityType(), $entities);
    // Invalidate all caches of offers whenever bids are deleted
    foreach($entities as $entity) {
      $offer = Offer::load($entity->get('offer_id')->target_id);
      if($offer) {
        Cache::invalidateTags($offer->getCacheTagsToInvalidate());
      }
    }
  }

}

















