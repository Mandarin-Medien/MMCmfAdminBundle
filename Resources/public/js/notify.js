$.extend({
    notify: function (message, options) {

        var defaults = {
            target: 'body',
            autoClose: 5000,
            removeTimeout: 3000,
        };

        var notification = function(message, target)
        {
            var self = this;

            this.message = $('<div class="notification">'+message+'</div>');
            this.target = target;


            this.render = function() {
                $(this.message).appendTo(target);
                $(this.message).trigger(new $.Event('notification.render', {'notification' : self}));
            };

            this.close = function() {
                $(this.message).addClass('closed');
                $(this.message).trigger(new $.Event('notification.close', {'notification' : self}));
            };

            this.remove = function() {
                $(this.message).remove();
                $(this.message).trigger(new $.Event('notification.remove', {'notification' : self}));
            };
        };

        // merge defaults with options
        var settings = $.extend(defaults, options);

        // create the notification
        var _notification = new notification(message, settings.target);

        _notification.render();

        setTimeout(function() {_notification.close()}, settings.autoClose);

        $(_notification.message).on('notification.close', function(e) {
            setTimeout(function() {
                e.notification.remove();
                delete _notification;
            }, settings.removeTimeout);
        });
    }
});