<?php

namespace Drupal\offer\EventSubscriber;

use Drupal\offer\Event\UserLoginEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class UserLoginSubscriber.
 *
 * @package Drupal\custom_events\EventSubscriber
 */
class UserLoginSubscriber implements EventSubscriberInterface
{
  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents()
  {
    return [
      UserLoginEvent::EVENT_NAME =>  ['onUserLogin', 29]
    ];
  }

  /**
   * Subscribe to the user login event dispatched.
   *
   * @param \Drupal\custom_events\Event\UserLoginEvent $event
   *   Dat event object yo.
   */
  public function onUserLogin(UserLoginEvent $event)
  {
    $username = \Drupal::currentUser()->getDisplayName();
    \Drupal::messenger()->addStatus(t('Welcome %name, happy bidding!', [
      '%name' => $username,
    ]));
    $response = new RedirectResponse("/");
    $response->send();
  }

}

