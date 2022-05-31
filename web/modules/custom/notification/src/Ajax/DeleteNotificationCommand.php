<?php

namespace Drupal\notification\Ajax;

use Drupal\Core\Ajax\CommandInterface;

class DeleteNotificationCommand implements CommandInterface {

  public function render() {
    return [
      'command' => 'DeleteNotification',
      'selector' => 'view-id-notifications'
    ];
  }
}
