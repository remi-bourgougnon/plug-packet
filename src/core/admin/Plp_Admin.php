<?php

namespace plp\core\admin;

class Plp_Admin
{
    public function __construct()
    {
        // Enqueue the css and the js files
        wp_enqueue_style('plp_admin_css', plugins_url() . '/plug-packet/src/assets/css/admin.css');
        wp_enqueue_script('plp_admin_js', plugins_url() . '/plug-packet/src/assets/js/admin.js');

        add_action('admin_menu', [$this, 'generate_packs_menu']);

        add_action('wp_ajax_install_and_activate_pack_plugins', [$this, 'install_and_activate_pack_plugins']);
    }

    /**
     * Add the top level menu
     *
     * @return void
     */
    function generate_packs_menu(): void
    {
        add_menu_page(
            'PlugPacket',
            'PlugPacket',
            'manage_options',
            'plugpacket',
            [$this, 'generate_packs_html'],
            25,
            25
        );
    }

    /**
     * Displays the plugin packs and adds checkmarks to plugins already installed.
     *
     * @return void
     */
    function generate_packs_html(): void
    {
        $plp_packs = [
            'basicpack_1' => [
                'title' => 'Basic Pack 1',
                'list' => [
                    'Elementor',
                    'UpdraftPlus',
                    'Really Simple SSL',
                    'Wordfence Security',
                    'Site Kit by Google',
                    'Yoast SEO'
                ],
                'image' => 'image_pack.png',
                'plugins' => [
                    'elementor',
                    'updraftplus',
                    'really-simple-ssl',
                    'wordfence',
                    'google-site-kit',
                    'wordpress-seo'
                ],
                'plugin_files' => [
                    'elementor',
                    'updraftplus',
                    'rlrsssl-really-simple-ssl',
                    'wordfence',
                    'google-site-kit',
                    'wp-seo'
                ]
            ],
            'basicpack_2' => [
                'title' => 'Basic Pack 2',
                'list' => [
                    'Beaver Builder',
                    'Jetpack',
                    'WP Force SSL',
                    'MonsterInsights',
                    'All in One SEO'

                ],
                'image' => 'image_pack.png',
                'plugins' => [
                    'beaver-builder-lite-version',
                    'jetpack',
                    'wp-force-ssl',
                    'google-analytics-for-wordpress',
                    'all-in-one-seo-pack'
                ],
                'plugin_files' => [
                    'fl-builder',
                    'jetpack',
                    'wp-force-ssl',
                    'googleanalytics',
                    'all_in_one_seo_pack'
                ]
            ]
        ];
        ?>
        <link rel="stylesheet"
              href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <div class="plp-packs">
            <?php
            foreach ($plp_packs as $plp_pack_name => $plp_pack) {
                //the code that displays the plugin pack
                ?>
                <div class="plp-pack">
                    <div class="plp-pack-image"><img src="<?php echo plugins_url() . '/plug-packet/src/assets/images/' . $plp_pack['image']; ?>">
                    </div>
                    <div class="plp-pack-title"><?php echo $plp_pack['title'] ?></div>
                    <div class="plp-pack-list">
                        <ul><?php for ($i = 0; $i < count($plp_pack['list']); $i++) {
                                if (is_plugin_active($plp_pack['plugins'][$i] . '/' . $plp_pack['plugin_files'][$i] . '.php')) {
                                    echo '<li>' . $plp_pack['list'][$i] . ' <i class="fa fa-check-circle plp-checkmark"></i></li>';
                                } else {
                                    echo '<li>' . $plp_pack['list'][$i] . ' </li>';
                                }
                            } ?></ul>
                    </div>
                    <div class="plp-pack-buttons">
                        <button class="plp-install-pack-button <?php echo $plp_pack_name; ?>"><i
                                    class="fa fa-download"></i>
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

    /**
     * Called by Ajax to install and activate the plugins in the selected pack.
     */
    function install_and_activate_pack_plugins()
    {
        $plp_packs = [
            'basicpack_1' => [
                'plugins' => [
                    'elementor',
                    'updraftplus',
                    'really-simple-ssl',
                    'wordfence',
                    'google-site-kit',
                    'wordpress-seo'
                ],
                'plugin_files' => [
                    'elementor',
                    'updraftplus',
                    'rlrsssl-really-simple-ssl',
                    'wordfence',
                    'google-site-kit',
                    'wp-seo'
                ]
            ],
            'basicpack_2' => [
                'plugins' => [
                    'beaver-builder-lite-version',
                    'jetpack',
                    'wp-force-ssl',
                    'google-analytics-for-wordpress',
                    'all-in-one-seo-pack'
                ],
                'plugin_files' => [
                    'fl-builder',
                    'jetpack',
                    'wp-force-ssl',
                    'googleanalytics',
                    'all_in_one_seo_pack'
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
}