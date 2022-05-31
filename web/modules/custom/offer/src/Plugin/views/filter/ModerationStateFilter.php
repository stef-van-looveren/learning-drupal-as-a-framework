<?php

namespace Drupal\offer\Plugin\views\filter;

use Drupal\Core\Database\Connection;
use Drupal\views\Plugin\views\filter\InOperator;
use Drupal\views\ViewExecutable;
use Drupal\views\Plugin\views\display\DisplayPluginBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Filter class which filters by the available ModerationStates.
 *
 * @ViewsFilter("offer_moderation_state_filter")
 */
class ModerationStateFilter extends InOperator {


  /**
   * @var \Drupal\Core\Database\Connection
   */
  protected $database;

  /**
   * Constructs a Bundle object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, Connection $database) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->database = $database;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('database')
    );
  }

  /**
   * Override the query so that no filtering takes place if the user doesn't
   * select any options.
   */
  public function query() {

    // Get the selected value first
    $selected = $this->value;

    // If 'all' is selected, do not filter. This would mean all offers
    if(!in_array('all', $selected)) {

      $configuration = [
        'table' => 'content_moderation_state_field_data',
        'field' => 'content_entity_id',
        'left_table' => 'offer',
        'left_field' => 'id',
        'operator' => '='
      ];
      $join = \Drupal::service('plugin.manager.views.join')->createInstance('standard', $configuration);

      $this->query->addRelationship('content_moderation_state_field_data', $join, 'offer');

      $this->query->addWhere('AND', 'content_moderation_state_field_data.moderation_state', $selected, 'IN');

    }
  }

  /**
   * {@inheritdoc}
   */
  public function init(ViewExecutable $view, DisplayPluginBase $display, array &$options = NULL) {
    parent::init($view, $display, $options);
    $this->valueTitle = t('Moderation state');
    $this->definition['options callback'] = [$this, 'getModerationStates'];
  }

  /**
   * Generates the list of ModerationStates that can be used in the filter.
   */
  public function getModerationStates() {
    $result = [
      'draft' => 'Draft',
      'published' => 'Published',
      'expired' => 'Expired'
    ];
    return $result;
  }
}
