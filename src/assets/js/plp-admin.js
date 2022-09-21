jQuery(document).ready(function($) {

    jQuery(".plp-install-pack-button").click(function(){
        let pack_name = $(this).data('plp-packname');
        let button_clicked = $(this);

        $('.plp-error-message').remove();

        jQuery.post(ajaxurl, { action: "plp_install_and_activate_pack_plugins", pack_name: pack_name}, function(data) {
            if (data !== undefined && data !== '') {
                $('<div class="plp-error-message">' + data + '</div>').insertAfter(button_clicked);
                if(jQuery('.plp-install-pack-button').find('.plp-button-icon').hasClass("fa-refresh fa-spin")) {
                    jQuery('.plp-install-pack-button').find('.plp-button-icon').addClass("fa-download").removeClass("fa-refresh fa-spin");
                }
                return false;
            }
            if(jQuery('.plp-install-pack-button').find('.plp-button-icon').hasClass("fa-refresh fa-spin")) {
                jQuery('.plp-install-pack-button').find('.plp-button-icon').addClass("fa-download").removeClass("fa-refresh fa-spin");
                location.reload(true);
            }
        });

        if(jQuery(this).find('.plp-button-icon').hasClass("fa-download")) {
            jQuery(this).find('.plp-button-icon').addClass("fa-refresh fa-spin").removeClass("fa-download");
        }

        $('button').not(this).prop('disabled', true);
    });
})