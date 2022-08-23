<?php
/**
 * Plugin Name: PlugPacket
 */

/**
 * Register the "book" custom post type
 */
function plug_packet_settings_page() {
    include 'core/admin/admin.php';
}
add_action( 'init', 'plug_packet_settings_page' );


/**
 * Activate the plugin.
 */
function plug_packet_activate() {
    plug_packet_settings_page();
}
register_activation_hook( __FILE__, 'plugin_packet_activate' );
