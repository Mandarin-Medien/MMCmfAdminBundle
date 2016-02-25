(function($) {
    $.extend({
        MMCmfAdminMenu : new function()
        {

            var __construct = function (settings) {

                return this.each(function() {

                    var menu = this;


                    // make things draggable
                    dragula({

                        isContainer: function (el) {
                            return $(el).hasClass('admin-menu-list') || $(el).hasClass('admin-menu-list') ;
                        },

                        invalid: function(el, handle) {
                            return !$(handle).hasClass('draggable');
                        }
                    }).on('dragend', function() {
                        updateMenu(menu);
                    });

                    $(document).on('mouseover', '.admin-menu-item', menu, function(e) {
                        this.to = setTimeout(function() {
                            $(e.currentTarget).addClass('showsublist')
                        }, 500);
                    });
                    $(document).on('mouseout', '.admin-menu-item', menu, function(e) {
                        if(typeof this.to != 'undefined') clearTimeout(this.to);

                        $(e.currentTarget).removeClass('showsublist')
                    });
                    $(document).on('click', '.menu-add-item', menu, addItem);
                    $(document).on('click', '.menu-remove-item', menu, removeItem);

                });
            };

            /**
             * adds a new menu entry based on the prototype data property
             * @param e
             */
            var addItem = function(e)
            {
                e.preventDefault();

                var proto = $(e.currentTarget).data('prototype');

                $(e.data).append(proto);

                updateMenu(e.data);
            };


            /**
             * removes an menu entry from the list
             * @param e
             */
            var removeItem = function(e)
            {
                e.preventDefault();

                $(e.currentTarget).parents('.admin-menu-item').remove();

                updateMenu(e.data);
            };



            /**
             * updates the fielnames and values of the current given menu
             * @param menu
             */
            var updateMenu = function(menu, _menu_field_base, parent)
            {
                var menu_field_base = typeof _menu_field_base == 'undefined' ? $(menu).data('name') : _menu_field_base + '['+$(menu).data('name')+']';

                if(typeof parent == 'undefiend') parent = 1;

                $.each($(menu).children('li'), function(key, item)
                {

                    // build the field name base
                    var item_field_base = menu_field_base+'['+key+']';

                    // update field names
                    $(this).find('input, select').each(function() {
                        var field_name = item_field_base + $(this).attr('name').match(/\[([_\w]+)\]$/)[0];
                        $(this).attr('name', field_name);
                    });

                    // set the position and parent values
                    $(this).find('.position-field').val(key);
                    $(this).find('.parent-field').val(parent);


                    // update submenus recursively
                    var submenu = $(this).children('ul');
                    if(submenu.length)  {
                        updateMenu(submenu, item_field_base, key);
                    }
                });
            };


            // make plugin callable
            $.fn.extend({
                MMCmfAdminMenu : __construct
            });
        }
    });
})(jQuery);