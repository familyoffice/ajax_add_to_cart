(function ($, Drupal) {
  'use strict';
  Drupal.AjaxCommands.prototype.reload = function (ajax, response, status) {
    setTimeout(
    function() {
      $(".ui-dialog .ui-button").click();
    }, 2000);
  };
})(jQuery, Drupal);
