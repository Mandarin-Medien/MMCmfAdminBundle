// admin form field types
var mmFormFieldhandler;

jQuery(document).ready(function() {

    mmFormFieldhandler = new FormHandler();
    mmFormFieldhandler.init();

    $(document).MMCmfAdmin();

    $('iframe').MMCmfAdminEditFrame();

    $(window).resize(function() {
        $('.mmcmfadmin-editframe-container').height($('.content-wrapper').css('min-height'));
    });

    $('.mmcmfadmin-editframe-container').height($('.content-wrapper').css('min-height'));
});