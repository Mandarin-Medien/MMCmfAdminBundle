(function($) {
    $.extend({
        MMCmfAdmin : new function()
        {

            var __construct = function (settings) {

                $(document).on('iframe:pageshow', function(e) {
                   setRoot(e.target.contentDocument.mm_cmf_admin.root_node);
                });

                return this.each(function() {

                    $(this).on('submit', '.xhr form, form[rel="ajax"]', false, ajaxSubmit);

                    // init tabs
                    $('.xhr')
                        .MMCmfAdminSidebarTabs()
                        .on('mmcmfadmin:tabs:add:first', function(e) {
                            $('.xhr').addClass('visible');
                        })
                        .on('mmcmfadmin:tabs:close:last', function(e) {
                            $('.xhr').removeClass('visible');
                        })
                        .on('mmcmfadmin:tabs:add', function(e) {

                            // overwrite abort button
                            $(e.tabdata.tab).find('.btn-abort').bind('click', function(e) {
                                e.preventDefault();
                                $(this).trigger('tab:close');
                            });

                            // bind xhr
                            $(e.tabdata.tab).find('a[rel=ajax]').MMCmfAdminXHR({
                                'success' : xhrSuccessCallback,
                                'error' : xhrErrorCallback
                            });

                            // overwrite save and add button
                           // $(e.tabdata.tab).find('button')
                        });

                    // bind xhr
                    $('a[rel=ajax]').MMCmfAdminXHR({
                        'success' : xhrSuccessCallback,
                        'error' : xhrErrorCallback
                    });

                });

            };


            var xhrSuccessCallback = function(response) {

                if(response.success) {

                    $('.xhr').MMCmfAdminSidebarTabs('add', {
                        icon: response.data.icon,
                        name: response.data.name,
                        content: response.data.content
                    });


                    mmFormFieldhandler.init();
                }
            };

            var xhrErrorCallback = function(xhr, text, errorMsg) {
                $.notify('Fehler: '+xhr.status +': '+ xhr.statusText );
            };


            var setRoot = function(id) {
                $('a[data-fetch-root="true"]').each(function() {
                    $(this).data('root', id);
                });
            };


            /**
             * general ajax submit for forms in admin
             * @param e Event
             * @returns void
             */
            var ajaxSubmit = function(e) {

                e.preventDefault();

                var form = e.currentTarget;
                var method = form.getAttribute('method');
                var action = form.getAttribute('action');
                var data = new FormData(form);

                $.ajax({
                    'url' : action,
                    'type' : method,
                    'data' : data,
                    'processData': false,
                    'contentType': false,

                    // response success action
                    'success' : function(response)
                    {

                        // Validation success
                        if(response.success == true)
                        {

                            if(response.data.redirect) {
                                window.location.href = response.data.redirect;
                            }


                            $(form).trigger(createFormEvent('validation:success', response.data));
                            $.notify('<i class="fa fa-check"></i> erfolgreich gespeichert');

                            // close the overlay
                            $(form).trigger('tab:close');

                            // reload iframe
                            $('iframe').MMCmfAdminEditFrame('reload');

                        }

                        // Validation failure
                        else {

                            $(form).trigger(createFormEvent('validation:fail', response.data));

                            var message = '<div style="margin-bottom: 10px"><i class="fa fa-times"></i> speichern fehlgeschlagen</div>';

                            //$.notify('<i class="fa fa-times"></i> speichern fehlgeschlagen');

                            if(response.data.errors) {

                                for(var name in response.data.errors)
                                {
                                    // validation hints the bootstrap way, may not work with other form markup structure
                                    /* TODO: put validation messages to markup */
                                    $('[name="'+response.data.form+'['+name+']"]').parent().addClass('has-error');

                                    message += '<div><i class="fa fa-warning"></i> '+response.data.errors[name]+'</div>';

                                }
                                message+= '</ul>';
                            }

                            $.notify(message);
                        }
                    },

                    // response error action
                    'error' : function(xhr, text, errorMsg) {
                        $(form).trigger(createFormEvent('validation:fail', data));
                        $.notify('<i class="fa fa-times"></i> '+xhr.status+': '+xhr.statusText);
                    }
                });
            };

            var handleXHR = function(response)
            {
                var target = $('.xhr');

                $(target).html(response);
                $(target).one('transitionend', function() {
                    $(target).addClass('shown');
                });

                $(target).addClass('visible');
                $(target).find('button.close').bind('click', function() {
                    $(target).removeClass('shown');
                    $(target).removeClass('visible');
                });

                $(document).on('overlay:close', function(e) {
                    $(target).removeClass('visible');
                });

                // init Formtypes
                mmFormFieldhandler.init();
            };


            var createFormEvent = function(event, eventData)
            {
                return $.Event('MMCmfAdmin:Form:'+event, eventData);
            };


            // make plugin callable
            $.fn.extend({
                MMCmfAdmin : __construct
            });
        }
    });
})(jQuery);