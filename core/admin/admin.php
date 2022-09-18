<?php

//enqueue the css and the js files
wp_enqueue_style('plp_admin_css', plugins_url() . '/plug-packet/assets/css/admin.css');
wp_enqueue_script('plp_admin_js', plugins_url() . '/plug-packet/assets/js/admin.js');

//add the top level menu which will call the 'plugin_packs_options_page_html' function when clicked
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

//This function displays the plugin packs and displays if some of the plugins listed in the packs are already installed.
function plugin_packs_options_page_html()
{
    $plugin_packs = [
        'basicpack' => [
            'title' => 'Basic Pack',
            'list' => [
                'Elementor',
                'UpdraftPlus',
                'Really Simple SSL'
            ],
            'image' => 'plug-packet/assets/images/image_pack.png',
            'plugins' => [
                'elementor',
                'updraftplus',
                'really-simple-ssl',
            ],
            'plugin_files' => [
                'elementor',
                'updraftplus',
                'rlrsssl-really-simple-ssl'
            ]
        ],
        'testpack' => [
            'title' => 'Test Pack',
            'list' => [
                'Jetpack',
            ],
            'image' => 'plug-packet/assets/images/image_pack.png',
            'plugins' => [
                'jetpack',
            ],
            'plugin_files' => [
                'jetpack',
            ]
        ]
    ];
    ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <div class="plugin-packs">
        <?php
        foreach ($plugin_packs as $plugin_pack_name => $plugin_pack) {
            //the code that displays the plugin pack
            ?>
            <div class="plugin-pack">
                <div class="plugin-pack-image"><img src="/wp-content/plugins/<?php echo $plugin_pack['image'] ?>">
                </div>
                <div class="plugin-pack-title"><?php echo $plugin_pack['title'] ?></div>
                <div class="plugin-pack-list"><ul><?php for ($i = 0; $i < count($plugin_pack['list']); $i++) {
                        if (is_plugin_active($plugin_pack['plugins'][$i] . '/' . $plugin_pack['plugin_files'][$i] . '.php')) {
                            echo '<li>' . $plugin_pack['list'][$i] . ' <i class="fa fa-check-circle plp-checkmark"></i></li>';
                        }
                        else {
                            echo '<li>'. $plugin_pack['list'][$i] . ' </li>';
                        }
                    } ?></ul></div>
                <div class="plugin-pack-buttons">
                    <button class="install-pack-button <?php echo $plugin_pack_name; ?>"><i class="fa fa-download"></i>
                        Install and Activate Pack
                    </button>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
    <?php
}

//This function is fired by Ajax when one of the plugin packs buttons is clicked. it executes a class method located in the 'plugin-installer.php' file
function plugin_pack_installer()
{
    $plugin_pack_plugins = [
        'basicpack' => [
            'plugins' => [
                'elementor',
                'updraftplus',
                'really-simple-ssl',
            ],
            'plugin_files' => [
                'elementor',
                'updraftplus',
                'rlrsssl-really-simple-ssl'
            ]
        ],
        'testpack' => [
            'plugins' => [
                'jetpack',
            ],
            'plugin_files' => [
                'jetpack',
            ]
        ]
    ];

    require_once plugin_dir_path(__FILE__) . 'plugin-installer/plugin-installer.php';
    $plugin_pack_installer = new Plug_Packet_Plugin_Installer();
        for ($i = 0; $i < count($plugin_pack_plugins[$_POST['data']]['plugins']); $i++) {
            if (is_plugin_active($plugin_pack_plugins[$_POST['data']]['plugins'][$i] . '/' . $plugin_pack_plugins[$_POST['data']]['plugin_files'][$i] . '.php') === false) {
                $plugin_pack_installer->plugin_packs_installer($plugin_pack_plugins[$_POST['data']]['plugins'][$i], $plugin_pack_plugins[$_POST['data']]['plugin_files'][$i]);
            }
        }
    wp_die();
}

add_action('wp_ajax_plugin_pack_installer', 'plugin_pack_installer');