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
                    'success' : function(response) {
                        if(data.success = true) {
                            $.notify('<i class="fa fa-check"></i> erfolgreich gespeichert');
                        } else {
                            $.notify('<i class="fa fa-times"></i> speichern fehlgeschlagen');
                        }
                    },
                    'error' : function(xhr, text, errorMsg) {
                        console.log(xhr, text, errorMsg);
                        $.notify('<i class="fa fa-times"></i> '+xhr.status+': '+xhr.statusText);
                    }
                });

                return false;
            };


            // make plugin callable
            $.fn.extend({
                MMCmfAdmin : __construct
            });
        }
    });
})(jQuery);