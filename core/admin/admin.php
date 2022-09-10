<?php

//enqueue the css file
wp_enqueue_style('admin.css', plugins_url(). '/plug-packet/assets/css/admin.css');
wp_enqueue_script('plp_admin_js', plugins_url() . '/plug-packet/assets/js/admin.js');
wp_localize_script('plp_admin_js', 'json_url', array(
    'jsonurl' => plugins_url() . '/plug-packet/assets/data/plugin_packs.json'
));

//add the top level menu
function plug_packet_options_page()
{
    add_menu_page(
        'PlugPacket',
        'PlugPacket',
        'manage_options',
        'plugpacket',
        'plugin_packs_options_page_html',
        25,
        25
    );
}

add_action('admin_menu', 'plug_packet_options_page');

//The plugin packs function.
function plugin_packs_options_page_html()
{
//    $plugin_packs = [
//        'Beginner Pack' => [
//            'title' => 'Basic Pack',
//            'list' => [
//                'Elementor Website Builder',
//                'UpdraftPlus WordPress Backup Plugin',
//                'Really Simple SSL'
//            ],
//            'image' => 'plug-packet/assets/images/image_pack.png'
//        ],
//        'Test Pack' => [
//            'title' => 'Test Pack',
//            'list' => [
//                'Beaver Builder – WordPress Page Builder'
//            ],
//            'image' => 'plug-packet/assets/images/image_pack.png'
//        ]
//    ];


    ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <div class="plugin-packs">
        <?php
        foreach ($plugin_packs as $plugin_pack) {
            //the code that displays the plugin pack
            ?>
            <div class="plugin-pack">
                <div class="plugin-pack-image"><img src="/wp-content/plugins/<?php echo $plugin_pack['image'] ?>">
                </div>
                <div class="plugin-pack-title"><?php echo $plugin_pack['title'] ?></div>
                <div class="plugin-pack-list"><?php foreach ($plugin_pack['list'] as $plugin_list) {
                        echo '- ' . $plugin_list . '<br>';
                    } ?></div>
                <div class="plugin-pack-buttons">
                    <button class="install-pack-button"><i class="fa fa-download"></i> Install and Activate Pack
                    </button>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
    <?php
}

//function that is executed when the button is pressed. installs the plugins
function plugin_pack_installer()
{
    $plugin_pack_plugins = array(
        '0' => 'elementor',
        '1' => 'updraftplus',
        '2' => 'really-simple-ssl',
    );
    $x = 0;
    require_once plugin_dir_path(__FILE__) . 'plugin-installer/plugin-installer.php';
    $plugin_pack_installer = new Plug_Packet_Plugin_Installer();
    foreach ($plugin_pack_plugins as $value) {
        $plugin_pack_installer->plugin_packs_installer($plugin_pack_plugins[$x]);
        $x = $x + 1;
    }
    wp_die();
}

add_action('wp_ajax_plugin_pack_installer', 'plugin_pack_installer');