<?php

namespace Drupal\offer\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class AboutPageController
 */
class AboutPageController extends ControllerBase {

  public function Render() {
    $config = \Drupal::config('offer.customconfig');

    $build = [
      '#markup' => $config->get('about'),
    ];

    $renderer = \Drupal::service('renderer');
    $renderer->addCacheableDependency($build, $config);

    return $build;
  }
}
