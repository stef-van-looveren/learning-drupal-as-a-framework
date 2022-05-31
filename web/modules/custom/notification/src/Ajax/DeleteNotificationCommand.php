<?php
namespace Drupal\notification\Ajax;
use Drupal\Core\Ajax\CommandInterface;

class DeleteNotificationCommand implements CommandInterface {

  protected $view;
  // Constructs a ReadMessageCommand object.
  public function __construct($view) {
    $this->view = $view;
  }

  // Implements Drupal\Core\Ajax\CommandInterface:render().
  public function render() {

    return array(
      'command' => 'DeleteNotification',
      'selector' => $this->selector,
      'responseData' => ''
    );
  }
}
