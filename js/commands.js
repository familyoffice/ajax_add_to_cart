(function ($, Drupal) {
  'use strict';
  Drupal.AjaxCommands.prototype.reload = function (ajax, response, status) {
    setTimeout(
      function () {
        $('.cart-block--contents').show();
      }, 1);
    setTimeout(
      function () {
        $(".ui-dialog .ui-button").click();
      }, drupalSettings.ajax_add_to_cart.ajax_add_to_cart.time);
  };
})(jQuery, Drupal);
