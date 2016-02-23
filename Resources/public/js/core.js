jQuery(document).ready(function() {

    $('iframe').MMCmfAdminEditFrame();


    var menu;

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
            });
});