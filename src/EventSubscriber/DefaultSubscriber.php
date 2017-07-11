<?php

namespace Drupal\ajax_add_to_cart\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

/**
 * Class DefaultSubscriber.
 */
class DefaultSubscriber implements EventSubscriberInterface {

  /**
   * Constructs a new DefaultSubscriber object.
   */
  public function __construct() {

  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events['kernel.request'] = ['unsetDrupalMessage'];

    return $events;
  }

  /**
   * This method is called whenever the kernel request event is dispatched.
   *
   * @param GetResponseEvent $event
   *   Event {@inheritdoc}.
   */
  public function unsetDrupalMessage(GetResponseEvent $event) {
    unset($_SESSION['messages']);
  }

}
