(function ($) {
    $.fn.MMCmfAdminEditFrame = function(options)
    {

        var defaults = {

            reload: '.refresh',
            viewportToggle: '.viewport-toggle',
            viewportReset: '.viewport-reset',

            viewports: {
                'xs': {
                    width: 360,
                    height: 480
                },

                'sm': {
                    width: 720,
                    height: 1080
                },

                'md': {
                    width: 1080,
                    height: 720
                },

                'lg': {
                    width: 1280,
                    height: 1080
                }
            }
        };


        /**
         * public method definition
         * @type {{close: methods.close}}
         */
        var methods = {
            reload: function() {this.reload();},
            reset: function() {this.reset();}
        };


        return this.each(function()
        {

            var self = this;
            var settings = $.extend(defaults, options);

            if(typeof options == 'object') {
                settings = this.settings = $.extend(defaults, options);
            } else if( typeof options == 'string' && typeof methods[options] != 'undefined') {
                return methods[options].apply(this);
            }


            self.init = function()
            {
                $(settings.reload).bind('click', function () {

                    $(this).find('.fa').addClass('fa-spin');
                    self.reload();
                });

                $(settings.viewportToggle).bind('click', function()
                {
                    var size = $(this).data('viewport');
                    toggleViewport(size);
                });

                $(settings.viewportReset).bind('click', function()
                {
                    self.reset();
                });

                $(self)
                    // start spinning the refresh button
                    .on('iframe:beforeunload', function(e)
                    {
                        $(settings.reload).find('.fa').addClass('fa-spin');
                    })

                    // stop spinning the refreh button
                    .on('iframe:load', function(e)
                    {
                        $(settings.reload).find('.fa').removeClass('fa-spin');
                    });

            };


            /**
             * reload the iframes content
             */
            self.reload = function()
            {
                this.contentWindow.location.reload(true);
            };

            self.reset = function()
            {
                $(self).css({
                    width:'100%',
                    'height': '100%'
                });
            };


            /**
             * calculate the height
             * @returns {number}
             */
            var calculateHeight = function()
            {
                return $('.content-wrapper').outerHeight();
            };


            var toggleViewport = function (size) {
                $(self).css({
                    width: settings.viewports[size].width,
                    height: settings.viewports[size].height < $(self).parent().height() ? settings.viewports[size].height : $(self).parent().height()
                });
            };


            self.init();
        });
    };
})(jQuery);