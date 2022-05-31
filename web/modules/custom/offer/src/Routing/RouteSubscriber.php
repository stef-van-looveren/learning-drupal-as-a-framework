<?php

namespace Drupal\offer\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

/**
 * Listens to the dynamic route events
 */
class RouteSubscriber extends RouteSubscriberBase {
  protected function alterRoutes(RouteCollection $collection)
  {

    $entityUserRegistrationFromRoute = $collection->get('user.register');
    if ($entityUserRegistrationFromRoute) {
      $entityUserRegistrationFromRoute->setDefaults([
        '_form' => '\Drupal\offer\Form\RegistrationForm',
        '_title' => 'Create your offer platform account'
      ]);
    }

  }
}
