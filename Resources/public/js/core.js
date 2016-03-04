var formhandler;

jQuery(document).ready(function() {

    $(document).MMCmfAdmin();

    $('iframe').MMCmfAdminEditFrame();
    $('.admin-menu-list-main').MMCmfAdminMenu();


    formhandler = new FormHandler();
    formhandler.init();


   /* var menu;

    var draggablePosition;

        var drake = dragula(
            {
                isContainer: function (el) {
                    return $(el).hasClass('admin-menu-list') || $(el).hasClass('admin-menu-list') ;
                },

                invalid: function(el, handle) {
                    return !$(handle).hasClass('draggable');
                }

            }
        )
            .on('over', function(foo, bar, foobar) {
            //console.log(foo, bar, foobar);
            })
            .on('drag', function(e, s) {
                $('.add-sub-item').show();
            })
            .on('dragend', function(s) {
                $('.add-sub-item').hide();

                updateRelations();
            });

    $('.add-menu-entry').click(function() {

        var prototype = $($(this).data('prototype'));

        $('.admin-menu-list-main').append(prototype);

        updateRelations();
        return false;
    });

    $('.admin-menu-item').each(function() {
        var item = this;

        $(this).find('a.remove').click(function() {
            $(item).remove();
        })
    });

    var updateRelations = function()
    {
        $.each($('.admin-menu-list'), function(key, menu) {

            var parent = $(menu).data('menu');

            $.each($(this).children('li'), function(index, item) {
                $(item).find('.position-field').val(index);
                $(item).find('.parent-field').val(parent);
            });
        });
    }*/
});