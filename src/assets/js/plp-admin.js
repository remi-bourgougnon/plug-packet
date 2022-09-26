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

            if (index < pack_plugins.length - 1) {
                call_ajax(++index, pack_plugins, button_clicked_icon);
            } else {
                // Stop loading icon when every plugin ajax is done
                if (button_clicked_icon !== null) {
                    button_clicked_icon.addClass("fa-download").removeClass("fa-refresh fa-spin");
                }
                $('.plp-install-pack-button-disabled').prop('disabled', false).addClass('plp-install-pack-button').removeClass('plp-install-pack-button-disabled');
            }

        });
    }

    $(".plp-install-pack-button").click(function () {
        let pack_plugins = $(this).data('plp-pack-plugins');
        let button_clicked_icon = $(this).find('.plp-button-icon');
        let plugin_icons = $(this).closest('.plp-pack').find('.plp-checkmark');

        // Loading icons
        button_clicked_icon.addClass("fa-refresh fa-spin").removeClass("fa-download");
        plugin_icons.addClass("fa-refresh fa-spin").removeClass("fa-check-circle").removeClass("fa-circle-o");

        // Call ajax on each plugin synchronously and recursively
        call_ajax(0, pack_plugins, button_clicked_icon);

        $('button').prop('disabled', true).addClass('plp-install-pack-button-disabled').removeClass('plp-install-pack-button');
    });

    $(".plp-plugin-icon-empty-circle").click(function () {
        let pack_plugins = [$(this).parent('li').data('plp-pack-plugin')];
        let plugin_icons = $(this);

        console.log(pack_plugins);

        // Loading icons
        plugin_icons.addClass("fa-refresh fa-spin").removeClass("fa-circle-o");

        // Call ajax on each plugin synchronously and recursively
        call_ajax(0, pack_plugins, null);

        $('button').not(this).prop('disabled', true).addClass('plp-install-pack-button-disabled').removeClass('plp-install-pack-button');
    });
});