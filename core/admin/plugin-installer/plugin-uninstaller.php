<?php

require_once(ABSPATH . 'wp-admin/includes/plugin-install.php');
require_once(ABSPATH . 'wp-admin/includes/class-wp-upgrader.php');
require_once(ABSPATH . 'wp-admin/includes/class-wp-ajax-upgrader-skin.php');
require_once(ABSPATH . 'wp-admin/includes/class-plugin-upgrader.php');
require_once(ABSPATH . '/wp-admin/includes/plugin.php');


class Plug_Packet_Plugin_Uninstaller
{
    function plugin_packs_uninstaller($plugins)
    {
        $simple_ssl = 'rlrsssl-really-simple-ssl';

        if (strpos($simple_ssl, $plugins) == false) {
            $plugin_path = array($plugins . '/' . $plugins . '.php');
            deactivate_plugins($plugin_path);
            delete_plugins($plugin_path);
        }

        elseif (strpos($simple_ssl, $plugins) !== false) {
            $plugin_path = array($plugins . '/' . $simple_ssl . '.php');
            deactivate_plugins($plugin_path);
            delete_plugins($plugin_path);
        }
    }
}