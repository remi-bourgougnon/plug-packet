<?php

namespace plp\core\admin;

//this lists contains every file needed to install and activate the plugins
use PHPMailer\PHPMailer\Exception;
use Plugin_Upgrader;
use WP_Ajax_Upgrader_Skin;

require_once(ABSPATH . 'wp-admin/includes/plugin-install.php');
require_once(ABSPATH . 'wp-admin/includes/class-wp-upgrader.php');
require_once(ABSPATH . 'wp-admin/includes/class-wp-ajax-upgrader-skin.php');
require_once(ABSPATH . 'wp-admin/includes/class-plugin-upgrader.php');
require_once(ABSPATH . '/wp-admin/includes/plugin.php');


class Plp_Plugin_Installer
{
    /**
     * Installs and activates a plugin
     *
     * @param string $plugin_slug
     * @param string $plugin_file
     * @return void
     * @throws \Exception
     */
    function install_and_activate_plugin($plugin_slug, $plugin_file)
    {
        $wordpress_api = plugins_api('plugin_information', ['slug' => $plugin_slug]); // Retrieves plugin installer pages of the plugin sent by the 'admin.php' page
        $ajax_upgrader_skin = new WP_Ajax_Upgrader_Skin();
        $plugin_upgrader = new Plugin_Upgrader($ajax_upgrader_skin);
        $installed = $plugin_upgrader->install($wordpress_api->download_link);

        if ((false === $installed)) {
            throw new \Exception('Installation failed without any explanation');
        } elseif ($installed instanceof \WP_Error) {
            throw new \Exception(sprintf('Installation failed with explanation: %s', $installed->get_error_message()));
        }

        $activated = activate_plugin($plugin_slug . '/' . $plugin_file . '.php');
        if ($activated instanceof \WP_Error) {
            throw new \Exception(sprintf('Activation failed with explanation: %s', $activated->get_error_message()));
        }
    }
}