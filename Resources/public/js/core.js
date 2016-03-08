jQuery(document).ready(function() {

    $(document).MMCmfAdmin();

    $('iframe').MMCmfAdminEditFrame();

    $(window).resize(function() {
        $('.mmcmfadmin-editframe-container').height($('.content-wrapper').css('min-height'));
    });

    $('.mmcmfadmin-editframe-container').height($('.content-wrapper').css('min-height'));
});