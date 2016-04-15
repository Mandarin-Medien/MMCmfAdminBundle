(function($) {

    $.fn.MMCmfAdminXHR = function(options)
    {

        var defaults = {
            success: function() {},
            error: function() {}
        };

        return this.each(function()
        {

            var self = this;
            var settings = this.settings = $.extend(defaults, options);

            /**
             * ajax call the given href
             * @param {Event} e
             */
            var call = function(e)
            {
                e.preventDefault();

                var url = e.currentTarget.getAttribute('href');

                var data = null;


                console.log(settings);


                if($(e.currentTarget).data('root')) {

                    if(url.indexOf('__root__') >= 0) {
                        url = url.replace('__root__', $(e.currentTarget).data('root'));
                    } else {
                        data = {
                            'parent_node': $(e.currentTarget).data('root')
                        }
                    }
                }


                $.ajax({
                    'url' : url,
                    'data' : data,
                    'success' : function(response)
                    {
                        self.dispatchEvent('xhr:success');
                        if(typeof settings.success == 'function') settings.success.call(this, response);
                    },

                    'error' : function(xhr, text, errorMsg)
                    {
                        self.dispatchEvent('xhr:error', {'xhr' : xhr});
                        if(typeof settings.error == 'function') settings.error.call(this, xhr, text, errorMsg);
                    }
                });

                self.dispatchEvent('xhr:call');
            };


            /**
             * trigger new event
             * Events wil be prefixed with mmcmfadmin:overlay
             *
             * @param {string} name Name of the event
             * @param {object=} data additional eventdata
             */
            this.dispatchEvent = function(name, data)
            {
                var eventData = $.extend({'mmcmfadminoverlay' : self}, data);
                var event = $.Event('mmcmfadmin:overlay:'+name, eventData);

                $(self).trigger(event);
            };

            $(self).bind('click', call);

        });
    }

})(jQuery);