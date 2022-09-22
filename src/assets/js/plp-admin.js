jQuery(document).ready(function ($) {

    $(".plp-install-pack-button").click(function () {
        let pack_plugins = $(this).data('plp-pack-plugins');
        let button_clicked = $(this);
        let button_clicked_icon = button_clicked.find('.plp-button-icon');

        $('.plp-error-message').remove();


        // Loading icon
        button_clicked_icon.addClass("fa-refresh fa-spin").removeClass("fa-download");

        let nb_pack_plugins = pack_plugins.length;

        $.each(pack_plugins, function (index, pack_plugin) {
            $.post(ajaxurl, {
                action: "plp_install_and_activate_pack_plugins",
                pack_plugin: pack_plugin
            }, function (data) {
                nb_pack_plugins--;


                if(nb_pack_plugins <= 0) {
                    // Stop loading icon when every plugin ajax is done
                    button_clicked_icon.addClass("fa-download").removeClass("fa-refresh fa-spin");
                }

                // Error management
                if (data !== undefined && data !== '') {
                    $('<div class="plp-error-message">' + data + '</div>').insertAfter($('.' + pack_plugin['slug']));
                    $('.' + pack_plugin['slug']).find('.plp-checkmark').hide();
                    return false;
                } else {
                    // No error: display the success icon
                    $('.' + pack_plugin['slug']).find('.plp-checkmark').show();
                }

            });
        });

        // $('button').not(this).prop('disabled', true);
    });
})