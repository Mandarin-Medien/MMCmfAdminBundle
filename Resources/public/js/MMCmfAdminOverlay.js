(function($) {

    $.fn.MMCmfAdminOverlay = function(options)
    {
        var defaults = {
            target: '.xhr',
            template: '<div class="mmcmfadmin-overlay-container"><a href="#" class="mmcmfadmin-overlay-close"><i class="fa fa-close"></i></a>%contents%'
        };

        var methods = {

            close: function()
            {
                this.dispatchEvent('close');
            }
        };

        return this.each(function()
        {

            var self = this;
            var settings = this.settings = defaults;


            if(typeof options == 'object') {
                settings = this.settings = $.extend(defaults, options);
            } else if( typeof options == 'string' && typeof methods[options] != 'undefined') {
                 return methods[options].apply(this);
            }

            /**
             * ajax call the given href
             * @param {Event} e
             */
            var call = function(e)
            {
                e.preventDefault();

                var url = e.currentTarget.getAttribute('href');

                var data = null;


                if($(e.currentTarget).data('root')) {
                    data = {
                        'parent_node' : $(e.currentTarget).data('root')
                    }
                }


                $.ajax({
                    'url' : url,
                    'data' : data,
                    'success' : function(response)
                    {
                        self.dispatchEvent('xhr:success');
                        handleResponse(response);
                    },

                    'error' : function(xhr, text, errorMsg)
                    {
                        self.dispatchEvent('xhr:error', {'xhr' : xhr});
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


            /**
             * handle the ajax response
             * @param {string} response
             */
            var handleResponse = function(response)
            {
                var content = $(settings.template.replace('%contents%', response));

                $(settings.target)
                    .html(content);

                $(content)
                    .find('.mmcmfadmin-overlay-close')
                    .bind('click', function() {
                        self.dispatchEvent('close');
                    });

                $(self).on('mmcmfadmin:overlay:close', function(e) {
                    $(content).remove();
                });

                self.dispatchEvent('append');
            };

            $(self).bind('click', call);

        });
    }

    $.fn.MMCmfAdminOverlay.close = function()
    {

        console.log(this);
    }

})(jQuery);