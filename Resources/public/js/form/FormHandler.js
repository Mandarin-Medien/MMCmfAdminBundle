var FormHandler = function()
{
    this.init = function() {
        $('[data-form-type="html"]').HTMLType();
        $('.node-tree').NodeTreeType();
    };
};