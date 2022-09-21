<?php
//this lists contains every file needed to install and activate the plugins
require_once(ABSPATH . 'wp-admin/includes/plugin-install.php');
require_once(ABSPATH . 'wp-admin/includes/class-wp-upgrader.php');
require_once(ABSPATH . 'wp-admin/includes/class-wp-ajax-upgrader-skin.php');
require_once(ABSPATH . 'wp-admin/includes/class-plugin-upgrader.php');
require_once(ABSPATH . '/wp-admin/includes/plugin.php');


class Plp_Plugin_Installer
{
    function plp_packs_installer($plugins, $file_names) //the plugin name and the main plugin file name are sent
    {
        $wordpress_api = plugins_api('plugin_information', ['slug' => $plugins]); //retrieves plugin installer pages of the plugin sent by the 'admin.php' page
        $ajax_upgrader_skin = new WP_Ajax_Upgrader_Skin(); //creates and ajax upgrader skin
        $plugin_upgrader = new Plugin_Upgrader($ajax_upgrader_skin);
        $plugin_upgrader->install($wordpress_api->download_link); //Installs the plugin

        readfile($plugins . '/' . $file_names . '.php'); //wait to see if the plugin file names exist
        activate_plugin($plugins . '/' . $file_names . '.php'); //activates the plugin.
    }
}