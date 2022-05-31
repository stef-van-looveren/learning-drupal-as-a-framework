<?php

namespace Drupal\notification\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\notification\Ajax\DeleteNotificationCommand;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\notification\Entity\Notification;
use Drupal\Core\Access\AccessResult;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\Core\Url;

/**
 * Class NotificationDeleteController.php.
 */
class NotificationDeleteController extends ControllerBase {

  public function Render($id, $method) {
    // Load the notification
    $notification = Notification::load($id);

    // Send back users that do not have access
    if(!$notification) {
      return AccessResult::forbidden();
    }
    if(!$notification->access('delete')) {
      return AccessResult::forbidden();
    }

    // Delete the notification
    $notification->delete();

    if($method == 'ajax') {
      $response = new AjaxResponse();
      $response->addCommand(new DeleteNotificationCommand('DeleteNotification'));
    } else {
      // no javascript: send back to page
      $path = Url::fromRoute('view.notifications.page_1')->toString();
      $response = new RedirectResponse($path);
      $response->send();
    }

    return $response;
  }

}
