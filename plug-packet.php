<?php
/**
 * Plugin Name:       PlugPacket
 * Description:       PlugPacket provides you with different packs to install your favorite plugins easily. PlugPacket does all that for you with a click of a button.
 * Version:           1.2
 * Author: PlugPacket Team
 * License: GPL2
 *
 * PlugPacket is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 * PlugPacket is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 */

use plp\core\admin\Plp_Admin;

define('PLP_VERSION', '1.2');
define('PLP_DIR', dirname(__FILE__));
define('PLP_DIR_URL', plugin_dir_url(__FILE__));
define('PLP_DIR_IMAGE_URL', PLP_DIR_URL . 'src/assets/images/');
define('PLP_DIR_IMAGE_CSS', PLP_DIR_URL . 'src/assets/css/');
define('PLP_DIR_IMAGE_JS', PLP_DIR_URL . 'src/assets/js/');

/**
 * The function is fired after WordPress has loaded. the action includes are admin.php file which is the main php file for the plugin admin settings page.
 */
function plp_settings_page()
{
    /**
     * PSR-4 autoloader from composer
     */
    require_once __DIR__ . '/vendor/autoload.php';

    /**
     *  Initialize the plugin
     */
    new Plp_Admin();
}

add_action('init', 'plp_settings_page');


/**
 * Sets the activation hook for the plugin. The function that we created above is then called.
 */
function plp_activate()
{
    plp_settings_page();
}

register_activation_hook(__FILE__, 'plp_activate');
