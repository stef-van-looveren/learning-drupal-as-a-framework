<?php

namespace  Drupal\offer\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\Cache;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Drupal\Core\Entity\EntityStorageInterface;

/**
 * @Block(
 *   id = "offer_bidding_table_block",
 *   admin_label = @Translation("Bidding table block"),
 *   category = @Translation("Shows the bidding table to an offer"),
 * )
 */

class OfferBiddingTableBlock extends BlockBase implements ContainerFactoryPluginInterface
{

  /**
   * The request object.
   *
   * @var \Symfony\Component\HttpFoundation\RequestStack
   */
  protected $requestStack;

  /**
   * The entity storage.
   *
   * @var \Drupal\Core\Entity\EntityStorageInterface
   */
  protected $entityStorage;

  /**
   * Constructs a new OfferBiddingTableBlock instance.
   *
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Symfony\Component\HttpFoundation\RequestStack $request_stack
   *   The request stack object.
   * @param \Drupal\Core\Entity\EntityStorageInterface $entity_storage
   *   The entity storage.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, RequestStack $request_stack, EntityStorageInterface $entity_storage)
  {
    parent::__construct($configuration, $plugin_id, $plugin_definition);

    $this->requestStack = $request_stack;
    $this->entityStorage = $entity_storage;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition)
  {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('request_stack'),
      $container->get('entity_type.manager')->getStorage('offer')
    );
  }

  /**
   * The bidding table
   */
  public function build() {
    $offer = $this->requestStack->getCurrentRequest()->get('offer');
    if(!$offer) {
      return null;
    }
    return $offer->getOfferBiddingTable();
  }

  /**
   * Cache per page
   */
  public function getCacheContexts() {
    return ['url.path'];
  }

  /**
   * Invalidate caches when there are new bids
   */
  public function getCacheTags() {
    $offer = $this->requestStack->getCurrentRequest()->get('offer');
    $offerId = $offer->id();
    return Cache::mergeTags(parent::getCacheTags(), ['offer:'.$offerId]);
  }


}













