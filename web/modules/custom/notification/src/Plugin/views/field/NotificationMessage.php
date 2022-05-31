<?php

namespace Drupal\notification\Plugin\views\field;

use Drupal\views\Plugin\views\field\FieldPluginBase;
use Drupal\views\ResultRow;
use Drupal\views\Plugin\views\display\DisplayPluginBase;
use Drupal\views\ViewExecutable;
use Drupal\offer\Entity\Offer;
use Drupal\Core\Url;
use Drupal\Core\Link;

/**
 * A handler to provide a field that is completely custom by the administrator.
 *
 * @ingroup views_field_handlers
 *
 * @ViewsField("notification_message")
 */
class NotificationMessage extends FieldPluginBase {

  /**
   * The current display.
   *
   * @var string
   *   The current display of the view.
   */
  protected $currentDisplay;

  /**
   * {@inheritdoc}
   */
  public function init(ViewExecutable $view, DisplayPluginBase $display, array &$options = NULL) {
    parent::init($view, $display, $options);
    $this->currentDisplay = $view->current_display;
  }

  /**
   * {@inheritdoc}
   */
  public function usesGroupBy() {
    return FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function query() {
    // Do nothing -- to override the parent query.
  }

  /**
   * {@inheritdoc}
   */
  protected function defineOptions() {
    $options = parent::defineOptions();
    $options['hide_alter_empty'] = ['default' => FALSE];
    return $options;
  }

  /**
   * {@inheritdoc}
   */
  public function render(ResultRow $values) {
    $entity = $values->_entity;
    $type = $entity->get('type')->getString();
    $offer_id = $entity->get('offer_id')->getString();
    $offer = Offer::load($offer_id);
    if($type == 'expired') {
      $url = Url::fromRoute('entity.offer.canonical', array('offer' => $offer->id()));
      $link = Link::fromTextAndUrl($offer->label(), $url)->toRenderable();
      $text = 'Offer '. \Drupal::service('renderer')->render($link) .' has expired.';
      // Add delete link for removing notifications
      $deleteUrl = Url::fromRoute('notification.delete', ['method' => 'nojs', 'id' => $entity->id()]);
      $deleteLink = Link::fromTextAndUrl('Remove', $deleteUrl)->toRenderable();
      $deleteLink['#attributes'] = ['class' => 'use-ajax'];
      $deleteText = \Drupal::service('renderer')->render($deleteLink);
      $output = $text . ' ' . $deleteText;
    }
    return [
      '#children' => $output
    ];
  }

}













