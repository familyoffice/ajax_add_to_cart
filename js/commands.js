(function ($, Drupal) {
  'use strict';
  Drupal.AjaxCommands.prototype.reload = function (ajax, response, status) {
    $('#drupal-modal a.cart-block--link__expand').click();
  };
})(jQuery, Drupal);
