<?php
/**
 * @file
 * Contains \Drupal\notification\Entity\notification.
 */

namespace Drupal\notification\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\EntityTypeInterface;

/**
 * Defines the notification entity.
 *
 * @ingroup notification
 *
 * @ContentEntityType(
 *   id = "notification",
 *   label = @Translation("notification"),
 *   base_table = "notification",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "title",
 *     "owner" = "uid",
 *     "uid" = "uid",
 *     "owner" = "uid",
 *   },
 *   handlers = {
 *     "access" = "Drupal\notification\NotificationAccessControlHandler",
 *     "views_data" = "Drupal\notification\NotificationViewsData",
 *   },
 * )
 */

class Notification extends ContentEntityBase {

  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type); // provides id and uuid fields

    $fields['user_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('User'))
      ->setDescription(t('The user the notification is for.'))
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default');

    $fields['offer_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Offer'))
      ->setDescription(t('The offer the notification is for.'))
      ->setSetting('target_type', 'offer')
      ->setSetting('handler', 'default');

    $fields['is_read'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t("Is read?"))
      ->setDescription(t('Is the notification read'));

    $fields['type'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Type'))
      ->setDescription(t('The type of notification: expired - raised'))
      ->setSettings([
        'max_length' => 150,
        'text_processing' => 0,
      ]);

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
  public function getOwnerId() {
    return $this->get('user_id')->target_id;
  }


}
