<?php
/**
 * @file
 * Contains \Drupal\offer\Entity\Offer.
 */

namespace Drupal\offer\Entity;

use Drupal\Core\Entity\EditorialContentEntityBase;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\bid\Entity\Bid;
use Drupal\Core\Cache\Cache;

/**
 * Defines the offer entity.
 *
 * @ingroup offer
 *
 * @ContentEntityType(
 *   id = "offer",
 *   label = @Translation("Offer"),
 *   base_table = "offer",
 *   data_table = "offer_field_data",
 *   revision_table = "offer_revision",
 *   revision_data_table = "offer_field_revision",
 *   entity_keys = {
 *     "id" = "id",
 *     "uuid" = "uuid",
 *     "label" = "title",
 *     "revision" = "vid",
 *     "status" = "status",
 *     "published" = "status",
 *     "uid" = "uid",
 *     "owner" = "uid",
 *   },
 *   handlers = {
 *     "access" = "Drupal\offer\OfferAccessControlHandler",
 *     "form" = {
 *       "add" = "Drupal\offer\Form\OfferForm",
 *       "edit" = "Drupal\offer\Form\OfferForm",
 *       "step_1" = "Drupal\offer\Form\OfferAddFormStep1",
 *       "step_2" = "Drupal\offer\Form\OfferAddFormStep2",
 *       "step_3" = "Drupal\offer\Form\OfferAddFormStep3",
 *       "delete" = "Drupal\offer\Form\OfferDeleteForm",
 *     },
 *     "views_data" = "Drupal\offer\OfferViewsData",
 *   },
 *   links = {
 *     "canonical" = "/offers/{offer}",
 *     "delete-form" = "/offer/{offer}/delete",
 *     "edit-form" = "/offer/{offer}/edit",
 *     "create" = "/offer/create",
 *   },
 *   field_ui_base_route = "entity.offer.settings",
 *   revision_metadata_keys = {
 *     "revision_user" = "revision_uid",
 *     "revision_created" = "revision_timestamp",
 *     "revision_log_message" = "revision_log"
 *   },
 * )
 */

class Offer extends EditorialContentEntityBase {

  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type); // provides id and uuid fields

    $fields['user_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('User'))
      ->setDescription(t('The user that created the offer.'))
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default')
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'author',
        'weight' => 0,
      ])
      ->setDisplayOptions('form', [
        'type' => 'entity_reference_autocomplete',
        'weight' => 5,
        'settings' => [
          'match_operator' => 'CONTAINS',
          'size' => '60',
          'autocomplete_type' => 'tags',
          'placeholder' => '',
        ],
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['title'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Title'))
      ->setDescription(t('The title of the offer'))
      ->setSettings([
        'max_length' => 150,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['status'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Publishing status'))
      ->setDescription(t('A boolean indicating whether the Offer entity is published.'))
      ->setDefaultValue(TRUE);

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
   *
   * Makes the current user the owner of the entity
   */
  public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
    parent::preCreate($storage_controller, $values);
    $values += array(
      'user_id' => \Drupal::currentUser()->id(),
    );
  }

  /**
   * {@inheritdoc}
   */
  public static function preDelete(EntityStorageInterface $storage, array $entities) {
    parent::preDelete($storage, $entities);

    // Delete all bids and notifications of the offer that will be deleted
    foreach ($entities as $entity) {
      $entity->deleteAllLinkedBids();
      $entity->deleteAllLinkedNotifications();
    }
  }

  /**
   * {@inheritdoc}
   */
  public function postCreate(EntityStorageInterface $storage) {
    Cache::invalidateTags(['my_offers_user_'. $this->getOwnerId()]);
  }

  /**
   * {@inheritdoc}
   */
  public static function postDelete(EntityStorageInterface $storage, array $entities) {
    parent::preDelete($storage, $entities);

    // Delete all bids and notifications of the offer that will be deleted
    foreach ($entities as $entity) {
      $entity->deleteAllLinkedBids();
      $entity->deleteAllLinkedNotifications();
      Cache::invalidateTags(['my_offers_user_'. $entity->getOwnerId()]);
    }

  }

  /**
   * Deletes all bids linked to the offer.
   * @param bool $delete
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  public function deleteAllLinkedBids($delete = FALSE) {
    $id = $this->id();

    $query = \Drupal::entityQuery('bid')
      ->condition('offer_id', $id);
    $bidIds = $query->execute();
    foreach($bidIds as $id) {
      $bid = Bid::load($id);
      $bid->delete();
    }
  }

  /**
   * Deletes all notifications linked to the offer.
   * @param bool $delete
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  public function deleteAllLinkedNotifications($delete = FALSE) {
    $id = $this->id();

    $query = \Drupal::entityQuery('notification')
      ->condition('offer_id', $id);
    $notificationIds = $query->execute();
    foreach($notificationIds as $id) {
      $notification = Notification::load($id);
      $notification->delete();
    }
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
   * Returns the highest bid on an offer
   * @return integer $price
   *  The price
   */
  public function getOfferHighestBid() {
    $bids = [];
    $id = $this->id();
    $query = \Drupal::entityQuery('bid')
      ->condition('offer_id', $id)
      ->sort('bid', 'ASC')
      ->range(NULL, 1);
    $bidIds = $query->execute();
    $price = null;
    foreach($bidIds as $id) {
      $bid = Bid::load($id);
      $price = $bid->get('bid')->getString();
    }
    return $price;
  }

  /**
   * Returns all bids of an offer
   * @return array $bids
   *  Array of bid entities
   */
  public function getOfferBids() {
    $bids = [];
    $id = $this->id();
    $query = \Drupal::entityQuery('bid')
      ->condition('offer_id', $id)
      ->sort('bid', 'DESC');
    $bidIds = $query->execute();
    foreach($bidIds as $id) {
      $bid = Bid::load($id);
      $bids[] = $bid;
    }
    return $bids;
  }

  /**
   * Checks if the current user has bids on the current offer
   * @return bool
   *  True if it has, false if it doesn't
   */
  public function CurrentUserHasBids() {
    $user_id = \Drupal::currentUser()->id();
    $id = $this->id();
    $query = \Drupal::entityQuery('bid')
      ->condition('offer_id', $id)
      ->condition('user_id', $user_id);
    $count = $query->count()->execute();
    if($count > 0) {
      return true;
    } else {
      return false;
    }
  }

  /**
   * Returns the current users bid on the offer
   * @return Drupal\bid\Entity\Bid Bid
   *  The offer entity
   */
  function currentUserBid() {
    $user_id = \Drupal::currentUser()->id();
    $id = $this->id();
    $query = \Drupal::entityQuery('bid')
      ->condition('offer_id', $id)
      ->condition('user_id', $user_id);
    $result = $query->execute();
    $bidId = reset($result);
    $bid = Bid::load($bidId);
    return $bid;
  }

}
