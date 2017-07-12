<?php

namespace Drupal\ajax_add_to_cart\Helper;

use Drupal\Core\Ajax\OpenModalDialogCommand;
use Drupal\ajax_add_to_cart\Ajax\ReloadCommand;

/**
 * Class AjaxCartHelper.
 *
 * @package Drupal\modules\ajax_add_to_cart
 */
class AjaxCartHelper {

  /**
   * Keep class object.
   *
   * @var object
   */
  public static $helper = NULL;

  /**
   * Protected cartBlock variable.
   *
   * @var cartBlock
   */
  protected $cartBlock;

  /**
   * Private constructor to avoid instantiation.
   */
  private function __construct() {
    $container = \Drupal::getContainer();
    $this->cartBlock = $this->getCartBlock($container);
  }

  /**
   * Get class instance using this function.
   *
   * @return DomainRouteMetaHelper
   *   return Object.
   */
  public static function getInstance() {
    if (!self::$helper) {
      self::$helper = new AjaxCartHelper();
    }
    return self::$helper;
  }

  /**
   * Ajax add to cart Form.
   *
   * @param string $form_id
   *   Form id.
   * @param array $form
   *   Form array.
   *
   * @return string
   *   Return Form array.
   */
  public function ajaxAddToCartAjaxForm($form_id, &$form) {
    $messages = [
      $form_id => t('Adding to cart ...'),
    ];
    $form['#prefix'] = '<div id="modal_ajax_form_' . $form_id . '">';
    $form['#suffix'] = '</div>';
    $_SESSION['messages'] = [];
    $form['status_messages_' . $form_id] = [
      '#type' => 'status_messages',
      '#weight' => -10,
    ];
    $form['form_id'] = [
      '#type' => 'hidden',
      '#value' => $form_id,
    ];
    // // Add ajax callback to the form.
    $form['actions']['submit']['#ajax'] = [
      'callback' => 'ajax_add_to_cart_ajax_validate',
      'event' => 'click',
      '#attributes' => [
        'class' => [
          'use-ajax',
        ],
      ],
      'progress' => [
        'type' => 'throbber',
        'message' => $messages[$form_id],
      ],
    ];
    // Add ajax dialoge library to open the form in popup.
    // Adding own library to add extra functionality.
    $form['#attached']['library'][] = 'ajax_add_to_cart/ajax_add_to_cart.commands';
    $form['#attached']['library'][] = 'core/drupal.dialog.ajax';
    return $form;
  }

  /**
   * Ajax add to cart response.
   *
   * @param string $form_id
   *   Form id.
   * @param object $response
   *   Response object to store information.
   *
   * @return object $response
   *   Return response object.
   */
  public function ajaxAddToCartAjaxResponse($form_id, $response) {
    // Adding modal window.
    $options = [
      'width' => 300,
      'height' => 350,
    ];
    $settings = [
      $form_id => [
        'title' => t('Successful Added'),
      ],
    ];
    $title = $settings[$form_id]['title'];
    $response->addCommand(new OpenModalDialogCommand($title, $this->cartBlock, $options));
    $response->addCommand(new ReloadCommand());
    unset($_SESSION['messages']);
    return $response;
  }

  /**
   * Get cart block.
   *
   * @param object $container
   *   Container object.
   *
   * @return object $render
   *   Return render object.
   */
  private function getCartBlock($container = NULL) {
    $customblock = $container->get('plugin.manager.block')->createInstance('commerce_cart', []);
    $render = $customblock->build();
    return $render;
  }

}
