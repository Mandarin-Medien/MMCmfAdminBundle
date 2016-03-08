(function($) {

    $.fn.MMCmfAdminOverlay = function(settings)
    {
        var defaults = {
            target: '.xhr',
            template: '<div class="mmcmfadmin-overlay-container"><a href="#" class="mmcmfadmin-overlay-close"><i class="fa fa-close"></i></a>%contents%'
        };

        return this.each(function()
        {

            var self = this;
            var settings = $.extend(defaults, settings);


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
                        dispatchEvent('xhr:success');
                        handleResponse(response);
                    },

                    'error' : function(xhr, text, errorMsg)
                    {
                        dispatchEvent('xhr:error', {'xhr' : xhr});
                    }
                });

                dispatchEvent('call');
            };


            var close = function(overlay)
            {
                $(overlay).remove();
            };


            /**
             * trigger new event
             * Events wil be prefixed with mmcmfadmin:overlay
             *
             * @param {string} name Name of the event
             * @param {object=} data additional eventdata
             */
            var dispatchEvent = function(name, data)
            {
                var eventData = $.extend({}, data);
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
                       dispatchEvent('close');
                    });

                $(document).one('mmcmfadmin:overlay:close', function(e) {
                    close(content);
                });

                dispatchEvent('append');
            };

            $(self).bind('click', call);


        });
    }

})(jQuery);