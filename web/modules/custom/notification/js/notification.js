( function ($) {

    // Command to replace element
    Drupal.AjaxCommands.prototype.DeleteNotification = function(ajax, response, status) {
        if(status === 'success') {
            $('.view-id-notifications').trigger('RefreshView');
        }
    }
})(jQuery)
