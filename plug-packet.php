<?php
/**
 * Plugin Name:       PlugPacket
 * Plugin URI:        https://plugpacket.com/to/do/
 * Description:       PlugPacket provides you with different packs to install your favorite plugins easily.Maybe you don't know which plugin to install or you don't want to install each plugin manually. PlugPacket does all that for you.
 * Version:           1.0.0
 * Author:            to do
 * Author URI:        https://plugpacket.com/to/do/
 * License:           to do
 * License URI:       to do
 * Update URI:        to do
 * Text Domain:       to do
 * Domain Path:       to do

 * PlugPacket is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.

 * PlugPacket is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
*/



/**
 * The function is fired after WordPress has loaded. the action includes are admin.php file which is the main php file for the plugin admin settings page.
 */
function plug_packet_settings_page() {
    include 'core/admin/admin.php';
}
add_action( 'init', 'plug_packet_settings_page' );


/**
 * Sets the activation hook for the plugin. The function that we created above is then called.
 */
function plug_packet_activate() {
    plug_packet_settings_page();
}
register_activation_hook( __FILE__, 'plugin_packet_activate' );
