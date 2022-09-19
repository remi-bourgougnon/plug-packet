<?php

//enqueue the css and the js files
wp_enqueue_style('plp_admin_css', plugins_url() . '/plug-packet/assets/css/admin.css');
wp_enqueue_script('plp_admin_js', plugins_url() . '/plug-packet/assets/js/admin.js');

//add the top level menu which will call the 'plugin_packs_options_page_html' function when clicked
function plp_options_page()
{
    add_menu_page(
        'PlugPacket',
        'PlugPacket',
        'manage_options',
        'plugpacket',
        'plp_options_page_html',
        25,
        25
    );
}

add_action('admin_menu', 'plp_options_page');

//This function displays the plugin packs and displays if some of the plugins listed in the packs are already installed.
function plp_options_page_html()
{
    $plp_packs = [
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
    <div class="plp-packs">
        <?php
        foreach ($plp_packs as $plp_pack_name => $plp_pack) {
            //the code that displays the plugin pack
            ?>
            <div class="plp-pack">
                <div class="plp-pack-image"><img src="/wp-content/plugins/<?php echo $plp_pack['image'] ?>">
                </div>
                <div class="plp-pack-title"><?php echo $plp_pack['title'] ?></div>
                <div class="plp-pack-list"><ul><?php for ($i = 0; $i < count($plp_pack['list']); $i++) {
                        if (is_plugin_active($plp_pack['plugins'][$i] . '/' . $plp_pack['plugin_files'][$i] . '.php')) {
                            echo '<li>' . $plp_pack['list'][$i] . ' <i class="fa fa-check-circle plp-checkmark"></i></li>';
                        }
                        else {
                            echo '<li>'. $plp_pack['list'][$i] . ' </li>';
                        }
                    } ?></ul></div>
                <div class="plp-pack-buttons">
                    <button class="plp-install-pack-button <?php echo $plp_pack_name; ?>"><i class="fa fa-download"></i>
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
function plp_pack_installer()
{
    $plp_packs = [
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
    $plugin_pack_installer = new Plp_Plugin_Installer();
        for ($i = 0; $i < count($plp_packs[$_POST['data']]['plugins']); $i++) {
            if (is_plugin_active($plp_packs[$_POST['data']]['plugins'][$i] . '/' . $plp_packs[$_POST['data']]['plugin_files'][$i] . '.php') === false) {
                $plugin_pack_installer->plp_packs_installer($plp_packs[$_POST['data']]['plugins'][$i], $plp_packs[$_POST['data']]['plugin_files'][$i]);
            }
        }
    wp_die();
}

add_action('wp_ajax_plugin_pack_installer', 'plp_pack_installer');