<?php

namespace plp\core\admin;

use mysql_xdevapi\Exception;

class Plp_Admin
{
    const PACKS_DEFINITION = [
        'basicpack_1' => [
            'title' => 'Basic Pack 1',
            'image' => 'Basic_Pack_Base_image.png',
            'plugins' => [
                ['name' => 'Elementor', 'slug' => 'elementor', 'file' => 'elementor',],
                ['name' => 'UpdraftPlus', 'slug' => 'updraftplus', 'file' => 'updraftplus',],
                ['name' => 'Really Simple SSL', 'slug' => 'really-simple-ssl', 'file' => 'rlrsssl-really-simple-ssl',],
                ['name' => 'Wordfence Security', 'slug' => 'wordfence', 'file' => 'wordfence',],
                ['name' => 'Site Kit by Google', 'slug' => 'google-site-kit', 'file' => 'google-site-kit',],
                ['name' => 'Yoast SEO', 'slug' => 'wordpress-seo', 'file' => 'wp-seo',]
            ],
        ],
        'basicpack_2' => [
            'title' => 'Basic Pack 2',
            'image' => 'Basic_Pack_Base_image.png',
            'plugins' => [
                ['name' => 'Beaver Builder', 'slug' => 'beaver-builder-lite-version', 'file' => 'fl-builder',],
                ['name' => 'Jetpack', 'slug' => 'jetpack', 'file' => 'jetpack',],
                ['name' => 'WP Force SSL', 'slug' => 'wp-force-ssl', 'file' => 'wp-force-ssl',],
                ['name' => 'MonsterInsights', 'slug' => 'google-analytics-for-wordpress', 'file' => 'googleanalytics',],
                ['name' => 'All in One SEO', 'slug' => 'all-in-one-seo-pack', 'file' => 'all_in_one_seo_pack',]
            ],
        ]
    ];

    public function __construct()
    {
        // Enqueue the css and the js files
        wp_enqueue_style('plp_admin_css', sprintf('%s%s', PLP_DIR_IMAGE_CSS, 'plp-admin.css'), null, PLP_VERSION);
        wp_enqueue_script('plp_admin_js', sprintf('%s%s', PLP_DIR_IMAGE_JS, 'plp-admin.js'), null, PLP_VERSION);

        add_action('admin_menu', [$this, 'generate_packs_menu']);

        add_action('wp_ajax_plp_install_and_activate_pack_plugins', [$this, 'install_and_activate_pack_plugins']);
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
        ?>
        <div class="plp-packs">
            <?php
            foreach (self::PACKS_DEFINITION as $plp_pack_name => $plp_pack) {
                //the code that displays the plugin pack
                ?>
                <div class="plp-pack">
                    <div class="plp-pack-image"><img
                                src="<?php esc_html_e(sprintf('%s%s', PLP_DIR_IMAGE_URL, $plp_pack['image'])); ?>">
                    </div>
                    <div class="plp-pack-title"><?php esc_html_e($plp_pack['title']) ?></div>
                    <div class="plp-pack-list">
                        <ul><?php foreach ($plp_pack['plugins'] as $plugin) {
                                if (is_plugin_active($plugin['slug'] . '/' . $plugin['file'] . '.php')) {
                                    echo sprintf('<li data-plp-pack-plugin={"slug":"%s","file":"%s"} class="%s">%s <i class="plp-circle-check plp-checkmark plp-plugin-icon-checkmark"></i></li>', esc_attr($plugin["slug"]), esc_attr($plugin["file"]), esc_attr($plugin["slug"]), esc_html($plugin['name']));
                                } else {
                                    echo sprintf('<li data-plp-pack-plugin={"slug":"%s","file":"%s"} class="%s">%s <i class="plp-circle plp-checkmark plp-plugin-icon-empty-circle"></i><i class="plp-circle-xmark plp-plugin-icon-disabled" style="display: none"></i></li>', esc_attr($plugin["slug"]), esc_attr($plugin["file"]), esc_attr($plugin["slug"]), esc_html($plugin['name']));
                                }
                            } ?></ul>
                    </div>
                    <div class="plp-pack-buttons">
                        <button class="plp-install-pack-button"
                                data-plp-pack-plugins='<?php echo wp_json_encode($plp_pack['plugins']); ?>'><i
                                    class="plp-download plp-button-icon"></i>
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
        $errors = [];

        if (!empty($_POST['pack_plugin'])) {
            $plugin = [];
            foreach ($_POST['pack_plugin'] as $plugin_key => $plugin_values) {
                $key = sanitize_text_field($plugin_key);
                $value = sanitize_text_field($plugin_values);
                $plugin[$key] = $value;
            }
            $plugin_pack_installer = new Plp_Plugin_Installer();
            if (false === is_plugin_active($plugin['slug'] . '/' . $plugin['file'] . '.php')) {
                try {
                    $plugin_pack_installer->install_and_activate_plugin($plugin['slug'], $plugin['file']);
                } catch (\Exception $e) {
                    $errors[] = sprintf('Error on plugin %s: %s', $plugin['name'], $e->getMessage());
                }
            }
        } else {
            $errors[] = 'This pack does not exist';
        }

        if (!empty($errors)) {
            foreach ($errors as $error) {
                echo '<br>' . esc_html($error);
            }
        }

        wp_die();
    }
}