(function($) {
    $.extend({
        MMCmfAdmin : new function() {


            var __construct = function (settings) {

                $(document).on('iframe:pageshow', function(e) {
                   setRoot(e.target.contentDocument.mm_cmf_admin.root_node);
                });

                return this.each(function() {

                    $(this).on('submit', '.xhr form', false, ajaxSubmit);
                    $(this).on('click', 'a[rel="ajax"]', false, ajaxFetch);
                });

            };

            var setRoot = function(id) {
                $('a[data-fetch-root="true"]').each(function() {
                    $(this).data('root', id);
                });
            };

            var ajaxFetch = function(e) {

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
                    'success' : function(response) {
                        handleXHR(response);
                    },
                    'error' : function(xhr, text, errorMsg) {
                        console.log(xhr, text, errorMsg);
                        $.notify('<i class="fa fa-times"></i> '+xhr.status+': '+xhr.statusText);
                    }
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
                        if(response.success == true) {

                            $(form).trigger(createFormEvent('validation:success', response.data));
                            $.notify('<i class="fa fa-check"></i> erfolgreich gespeichert');

                            $(document).trigger('overlay:close');
                            $(document).trigger('iframe:refresh');

                        }

                        // Validation failure
                        else {

                            $(form).trigger(createFormEvent('validation:fail', response.data));
                            $.notify('<i class="fa fa-times"></i> speichern fehlgeschlagen');

                            if(response.data.errors) {
                                for(var name in response.data.errors)
                                {
                                    // validation hints the bootstrap way, may not work with other form markup structure
                                    /* TODO: put validation messages to markup */
                                    $('[name="'+response.data.form+'['+name+']"]').parent().addClass('has-error');
                                }
                            }
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