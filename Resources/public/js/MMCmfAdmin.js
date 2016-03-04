(function($) {
    $.extend({
        MMCmfAdmin : new function() {


            var __construct = function (settings) {

                return this.each(function() {

                    $(this).on('submit', 'form[rel="ajax"]', false, ajaxSubmit);
                    $(this).on('click', '[rel="modal"]', false, ajaxModal);

                });
            };

            var ajaxModal = function(e) {

                e.preventDefault();

                var url = e.currentTarget.getAttribute('href');

                $.ajax({
                    'url' : url,
                    'success' : function(response) {
                        $('body').append(response);
                        $('.modal')
                            .modal()
                            .on('hidden.bs.modal', function() {
                                $(this).remove();
                            });
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