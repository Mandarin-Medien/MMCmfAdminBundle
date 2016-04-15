(function ($) {

    $.fn.MMCmfAdminSidebarTabs = function (options, data) {

        /**
         * default options
         * @type {{target: string, template: string}}
         */
        var defaults = {
            list: '.tabs-list',
            target: '.tabs',
        };

        return this.each(function () {

            var self = this;
            var tabs = [];
            this.settings;

            /**
             * public methid definition
             * @type {{close: methods.close}}
             */
            var methods = {
                add: function(params) {

                    console.log(data, params);

                    this.add(data.icon, data.name, data.content);
                }
            };

            if (typeof options == 'object' || typeof options == 'undefined') {
                settings = this.settings = $.extend(defaults, options);
            } else if (typeof options == 'string' && typeof methods[options] != 'undefined') {

                console.log('call');
                return methods[options].apply(this, data);
            }


            this.add = function (icon, name, content) {

                var tab = $('<div class="tab"><div class="tab-inner"><div class="tab-head"><span>'+name+'</span><a href="#" class="close-tab btn btn-danger"><i class="fa fa-close"></i></a></div>'+content+'</div></div>');
                var button = $('<li><a href="#"><i class="fa fa-' + icon + '"></i><span>' + name + '</span></a></li>');


                var tabdata = {
                    'button': button,
                    'tab': tab
                };

                $(button).data('tabdata', tabdata);
                $(tab).data('tabdata', tabdata);

                $(self.settings.target).append(tab);
                $(self.settings.list).append(button);

                toggle(tab);

                tabs.push(tabdata);

                $(button).bind('click', function(e) {
                    toggle(e.currentTarget);
                });

                $(tab).find('.close-tab').bind('click', function(e) {
                    $(this).trigger('tab:close');
                });

                $(tab).on('tab:close', function(e) {
                    close(e.currentTarget);
                });

                self.dispatchEvent('add', {tabdata: tabdata});

                if(tabs.length == 1) {
                    self.dispatchEvent('add:first', {tabdata: tabdata});
                }

            };

            var toggle = function(active)
            {
                $.each(tabs, function(index, tab) {
                    $(tab.tab).removeClass('active');
                    $(tab.button).removeClass('active');
                });

                var tab = $(active).data('tabdata').tab;
                var button = $(active).data('tabdata').button;

                tab.addClass('active');
                button.addClass('active');
            };

            var closeAll = function()
            {

                $('.tab').each(function() {
                    close(this);
                });
            };

            var close = function(active)
            {
                var tabdata = $(active).data('tabdata');
                var tab = $(active).data('tabdata').tab;
                var button = $(active).data('tabdata').button;

                tabs.splice(tabs.indexOf(tabdata), 1);


                self.dispatchEvent('close');

                if(tabs.length == 0) {
                    self.dispatchEvent('close:last');
                }

                tab.remove();
                button.remove();
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
                var event = $.Event('mmcmfadmin:tabs:'+name, eventData);

                $(self).trigger(event);
            };


            $(this).find('.close-all').bind('click', closeAll);

        });
    }

})(jQuery);