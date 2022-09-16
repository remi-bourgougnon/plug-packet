<?php

require_once(ABSPATH . 'wp-admin/includes/plugin-install.php');
require_once(ABSPATH . 'wp-admin/includes/class-wp-upgrader.php');
require_once(ABSPATH . 'wp-admin/includes/class-wp-ajax-upgrader-skin.php');
require_once(ABSPATH . 'wp-admin/includes/class-plugin-upgrader.php');
require_once(ABSPATH . '/wp-admin/includes/plugin.php');


class Plug_Packet_Plugin_Installer
{
    function plugin_packs_installer($plugins, $file_names)
    {
        $wordpress_api = plugins_api('plugin_information',
            array(
                'slug' => $plugins
            )
        );
        $ajax_upgrader_skin = new WP_Ajax_Upgrader_Skin();
        $plugin_upgrader = new Plugin_Upgrader($ajax_upgrader_skin);
        $plugin_upgrader->install($wordpress_api->download_link);

        readfile($plugins . '/' . $file_names . '.php');
        activate_plugin($plugins . '/' . $file_names . '.php');
    }
}