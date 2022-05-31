<?php

namespace Drupal\offer\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Session\AccountProxyInterface;

/**
 * @Block(
 *   id = "offer_bidding_block",
 *   admin_label = @Translation("Offer bid block"),
 *   category = @Translation("Shows the bidding block to an offer"),
 * )
 */

class OfferBiddingFormBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * @var $account \Drupal\Core\Session\AccountProxyInterface
   */
  protected $account;

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
   * Constructs a new OfferBiddingBlock instance.
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
  public function __construct(array $configuration, $plugin_id, $plugin_definition, RequestStack $request_stack, EntityStorageInterface $entity_storage, AccountProxyInterface $account) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);

    $this->requestStack = $request_stack;
    $this->entityStorage = $entity_storage;
    $this->account = $account;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('request_stack'),
      $container->get('entity_type.manager')->getStorage('offer'),
      $container->get('current_user')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    // Make sure this is an offer page
    $offer = $this->requestStack->getCurrentRequest()->get('offer');
    if(!$offer) {
      return null;
    }
    // Make sure the current user is not owner of the offer
    if($this->account->id() == $offer->getOwnerId()) {
      return null;
    }

    $form = \Drupal::formBuilder()->getForm('\Drupal\offer\Form\OfferBiddingForm', $offer);
    return $form;
  }

  /**
   * A form for authenticated users never gets cached.
   */
  public function getCacheMaxAge() {
    return 0;
  }

}
