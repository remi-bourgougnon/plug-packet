<?php

wp_enqueue_style('admin.css', '/wp-content/plugins/plug-packet/assets/css/admin.css');

function plug_packet_settings_init()
{
    register_setting('plugpacket', 'plugpacket_options');
}

add_action('admin_init', 'plug_packet_settings_init');

function plug_packet_options_page()
{
    add_menu_page(
        'PlugPacket',
        'PlugPacket',
        'manage_options',
        'plugpacket',
        'plug_options_page_html'
    );
}

add_action('admin_menu', 'plug_packet_options_page');

function plug_options_page_html()
{
    ?>
    <div class="plugin-packs">
        <div class="plugin-pack">
            <div class="plugin-pack-image"><img src=""></div>
            <div class="plugin-pack-title">test</div>
            <div class="plugin-pack-creator">by test</div>
            <div class="plugin-pack-buttons">
                <button class="install-pack-button">Install Pack</button>
                <button class="more-information-button">More info</button>
            </div>
        </div>
        <div class="plugin-pack">
            <div class="plugin-pack-image"><img src="/wp-content/plugins/mountain.jpeg"></div>
            <div class="plugin-pack-title">test</div>
            <div class="plugin-pack-creator">by test</div>
            <div class="plugin-pack-buttons">
                <button class="install-pack-button">Install Pack</button>
                <button class="more-information-button">More info</button>
            </div>
        </div>
        <div class="plugin-pack">
            <div class="plugin-pack-image"><img src="/wp-content/plugins/mountain.jpeg"></div>
            <div class="plugin-pack-title">test</div>
            <div class="plugin-pack-creator">by test</div>
            <div class="plugin-pack-buttons">
                <button class="install-pack-button">Install Pack</button>
                <button class="more-information-button">More info</button>
            </div>
        </div>
    </div>
    <?php
}