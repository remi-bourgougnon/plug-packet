jQuery(document).ready(function ($) {

    function call_ajax(index, pack_plugins, button_clicked_icon) {

        let pack_plugin = pack_plugins[index];

        $.post(ajaxurl, {
            action: "plp_install_and_activate_pack_plugins",
            pack_plugin: pack_plugin
        }, function (data) {

            const plugin_icon = $('.' + pack_plugin['slug']).find('.plp-checkmark');
            plugin_icon.addClass("fa-check-circle").removeClass("fa-refresh fa-spin");

            // Error management
            if (data !== undefined && data !== '') {
                $('<div class="plp-error-message">' + data + '</div>').insertAfter($('.' + pack_plugin['slug']));
                plugin_icon.hide();
            } else {
                // No error: display the success icon
                plugin_icon.show();
            }

            if (index < pack_plugins.length) {
                call_ajax(index++, pack_plugins);
            } else {
                // Stop loading icon when every plugin ajax is done
                button_clicked_icon.addClass("fa-download").removeClass("fa-refresh fa-spin");
            }

        });
    }

    $(".plp-install-pack-button").click(function () {
        let pack_plugins = $(this).data('plp-pack-plugins');
        let button_clicked = $(this);
        let button_clicked_icon = button_clicked.find('.plp-button-icon');
        let plugin_icons = $(this).closest('.plp-pack').find('.plp-checkmark');

        // Loading icons
        button_clicked_icon.addClass("fa-refresh fa-spin").removeClass("fa-download");
        plugin_icons.addClass("fa-refresh fa-spin").removeClass("fa-check-circle").show();

        // Call ajax on each plugin synchronously and recursively
        call_ajax(0, pack_plugins, button_clicked_icon);

    });

    // $('button').not(this).prop('disabled', true);
});