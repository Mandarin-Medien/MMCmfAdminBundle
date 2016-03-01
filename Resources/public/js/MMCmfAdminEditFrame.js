(function($) {
    $.extend({
        MMCmfAdminEditFrame : new function() {

            var defaults = {

                adressbar: '.adressbar',
                reload: '.reload',
                historyBack: '.history-back',
                historyFormward: '.history-forward',
                viewportsToggle: '.viewport-switch',

                viewports : {
                    'xs' : {
                        width: 360,
                        height: 480
                    },

                    'sm' : {
                        width: 720,
                        height: 1080
                    },

                    'md' : {
                        width: 1080,
                        height: 720
                    },

                    'lg' : {
                        width: 1280,
                        height: 1080
                    }
                }
            };


            var __construct = function (settings) {

                return this.each(function() {

                    var self = this;

                    // set options from settings and defaults
                    var options = $.extend(defaults, settings);


                    $(self).load(function() {
                        var path = this.contentWindow.location.pathname;
                        updateAdressbar(options, path);
                    });

                    $(options.historyBack).bind('click', function() {
                        historyBack(self);
                    });

                    $(options.historyFormward).bind('click', function() {
                        historyForward(self);
                    });

                    $(options.reload).bind('click', function() {
                        reload(self);
                    });

                    $(options.viewportsToggle).find('.viewport-toggle').each(function(){
                        var size = $(this).data('viewport');

                        $(this).bind('click', function() {
                            toggleViewport(self, options, size);
                        });
                    });

                    $(options.adressbar).on('keypress,', function(e) {

                        var code = e.which;

                        if(code == 13) {
                            e.preventDefault(true);

                            var path = ($(this).text());
                            self.contentWindow.location.pathname = path;

                            return false;
                        }
                    });


                    $(self).height(calculateHeight());
                });
            };


            var calculateHeight = function()
            {
                // get the fixed heights
                var fH = 0;

                fH += $('header.main-header').outerHeight();
                fH += $('footer.main-footer').outerHeight();

                console.log(fH);

                return $(window).height()-fH;
            };

            var historyBack = function(iframe)
            {
                iframe.contentWindow.history.back();
            };

            var historyForward = function(iframe)
            {
                iframe.contentWindow.history.forward();
            };

            var reload = function(iframe)
            {
                iframe.contentWindow.location.reload(true);
            };

            var updateAdressbar = function(options, path)
            {
                $(options.adressbar).text(path);
            };

            var toggleViewport = function(iframe, options, size)
            {
                $(iframe).css(
                    options.viewports[size]
                );
            };

            // make plugin callable
            $.fn.extend({
                MMCmfAdminEditFrame : __construct
            });
        }
    });
})(jQuery);