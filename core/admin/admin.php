<?php

//enqueue the css file
wp_enqueue_style('admin.css', '/wp-content/plugins/plug-packet/assets/css/admin.css');
wp_enqueue_script('admin.js', '/wp-content/plugins/plug-packet/assets/js/admin.js');

//add the top level menu
function plug_packet_options_page()
{
    add_menu_page(
        'PlugPacket',
        'PlugPacket',
        'manage_options',
        'plugpacket',
        'plugin_packs_options_page_html'
    );
}

add_action('admin_menu', 'plug_packet_options_page');

//The plugin packs function.
function plugin_packs_options_page_html()
{
    $x = 0;

    //create different variable for the title, images etc of the plugin packs
    $plugin_pack_titles = array(
        '0' => 'Basic Pack',
        '1' => 'Premium Pack',
        '2' => 'Premium Pack 2',
        '3' => 'test'
    );

    $plugin_pack_types = array(
        '0' => 'essentials',
        '1' => 'ecommerce',
        '2' => 'blog',
        '3' => 'test'
    );

    $plugin_pack_images = array(
        '0' => 'plug-packet/assets/images/cat.jpeg',
        '1' => 'plug-packet/assets/images/cat.jpeg',
        '2' => 'plug-packet/assets/images/cat.jpeg',
        '3' => 'plug-packet/assets/images/cat.jpeg',
    );

    $plugin_pack_plugins = array(
    );

    //function that is executed when the button is pressed. installs the plugins
    if (isset($_POST['install-pack-button'])) {
        require_once plugin_dir_path(__FILE__) . 'plugin-installer/plugin-installer.php';
        $plugin_pack_installer = new Plug_Packet_Plugin_Installer();
        foreach ($plugin_pack_plugins as $value) {
            $plugin_pack_installer->plugin_packs_installer($plugin_pack_plugins[$x]);
            $x = $x + 1;
        }
    }

    //function that is executed when the button is pressed. displays more information.
    if (isset($_POST['more-information-button'])) {
        echo "This is Button2 that is selected";
    }
    ?>
    <div class="plugin-packs">
        <?php
        foreach ($plugin_pack_titles as $value) {
            //the code that displays the plugin pack
            ?>
            <div class="plugin-pack">
                <div class="plugin-pack-image"><img src="/wp-content/plugins/<?php echo $plugin_pack_images[$x] ?>">
                </div>
                <div class="plugin-pack-title"><?php echo $plugin_pack_titles[$x] ?></div>
                <div class="plugin-pack-types"><?php echo $plugin_pack_types[$x] ?></div>
                <div class="plugin-pack-buttons">
                    <form method="post">
                        <input class="install-pack-button" type="submit" name="install-pack-button"
                               value="Install Pack"/>

                        <input class="more-information-button" type="submit" name="more-information-button"
                               value="More info"/>
                    </form>
                </div>
            </div>
            <?php
            $x = $x + 1;
        }
        ?>
    </div>
    <?php
}