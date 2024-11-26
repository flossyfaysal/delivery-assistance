<?php

namespace DeliveryAssistance\Frontend;

class Enqueue {
    public function __construct() {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_scripts']);
        add_action('init', [$this, 'register_blocks']);
    }

    function register_blocks() {
        // Enqueue block assets
        wp_register_script(
            'simple-block',
            plugins_url('assets/build/registration.js', __FILE__),
            [ 'wp-blocks', 'wp-element', 'wp-editor', 'wp-i18n' ],
            filemtime(plugin_dir_path(__FILE__) . 'assets/build/registration.js')
        );

        register_block_type( DELIVERY_ASSISTANCE_PLUGIN_URL . '/src/blocks/registration' );
        
    }

    public function enqueue_scripts() {
        wp_enqueue_style(
            'delivery-assistance-style',
            DELIVERY_ASSISTANCE_PLUGIN_URL . 'assets/css/style.css',
            [],
            '1.0'
        );

        wp_enqueue_script(
            'delivery-assistance-script',
            DELIVERY_ASSISTANCE_PLUGIN_URL . 'assets/js/script.js',
            ['jquery'],
            '1.0',
            true
        );
    }

    public function enqueue_admin_scripts($hook) {
        $screen = get_current_screen();

        // Enqueue admin CSS
        wp_enqueue_style(
            'delivery-assistance-admin-style',
            DELIVERY_ASSISTANCE_PLUGIN_URL . 'assets/css/admin/admin-style.css',
            [],
            '1.0'
        );

        // Fix the path for the settings CSS file
        $css_file = DELIVERY_ASSISTANCE_PLUGIN_URL. '../../assets/css/settings.css';
        if (file_exists($css_file)) {
            $css_version = filemtime($css_file); // Get the version from the file timestamp
        } else {
            $css_version = time(); // Fallback to current time if file does not exist
        }

        // Enqueue the settings CSS file
        wp_enqueue_style(
            'delivery-assistance-settings',
            DELIVERY_ASSISTANCE_PLUGIN_URL . 'assets/css/settings.css',
            [],
            $css_version // Use the correct version
        );

        // Fix the path for the settings JS file
        $js_file = DELIVERY_ASSISTANCE_PLUGIN_URL . '../../assets/js/settings.js';
        if (file_exists($js_file)) {
            $js_version = filemtime($js_file); // Get the version from the file timestamp
        } else {
            $js_version = time(); // Fallback to current time if file does not exist
        }

        // Enqueue the settings JS file
        wp_enqueue_script(
            'delivery-assistance-settings',
            DELIVERY_ASSISTANCE_PLUGIN_URL . 'assets/js/settings.js',
            ['wp-element', 'wp-api-fetch'],
            $js_version, // Use the correct version
            true
        );

        // Register block assets
        // wp_register_script(
        //     'delivery-assistance-blocks',
        //     DELIVERY_ASSISTANCE_PLUGIN_URL . 'assets/js/blocks/registration/index.js',
        //     ['wp-blocks', 'wp-element', 'wp-editor', 'wp-i18n'],
        //     filemtime(DELIVERY_ASSISTANCE_PLUGIN_DIR . 'assets/js/blocks/registration/index.js')
        // );

        // Localize script to pass data
        wp_localize_script(
            'delivery-assistance-settings',
            'DeliveryAssistanceData',
            array(
                'options' => get_option( 'delivery_assistance_options', array() ),
                'nonce'   => wp_create_nonce( 'wp_rest' ),
            )
        );
    }
}
