<?php

namespace DeliveryAssistance\Frontend;

class Enqueue {
    public function __construct() {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_scripts']);
        add_action('init', [$this, 'register_blocks']);
    }

    function register_blocks() {
        
        $blockDirs = glob(plugin_dir_path(__FILE__) . 'src/blocks/*/block.json');
        foreach ($blockDirs as $blockJsonPath) {
            register_block_type_from_metadata($blockJsonPath);
        }

        $blocksToRegister = array(
            'delivery-assistance/register' => 'delivery-assistance-registration',
            'delivery-assistance/login' => 'delivery-assistance-login',
        );

        wp_enqueue_script(
            'delivery-assistance-register',
            DELIVERY_ASSISTANCE_PLUGIN_URL . 'assets/js/build/register.js',
            ['wp-blocks', 'wp-element', 'wp-i18n', 'wp-editor'], // Dependencies
            filemtime(DELIVERY_ASSISTANCE_PLUGIN_URL . 'assets/js/build/register.js') // Cache-busting
        );

        // Register the block type
        register_block_type('delivery-assistance/register', [
            'editor_script' => 'delivery-assistance-register', 
        ]);
        
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
        $js_file = DELIVERY_ASSISTANCE_PLUGIN_URL . '../../assets/js/build/settings.js';
        if (file_exists($js_file)) {
            $js_version = filemtime($js_file); // Get the version from the file timestamp
        } else {
            $js_version = time(); // Fallback to current time if file does not exist
        }

        wp_enqueue_script(
            'delivery-assistance-settings',
            DELIVERY_ASSISTANCE_PLUGIN_URL . 'assets/js/build/settings.js',
            ['wp-element', 'wp-components', 'wp-api-fetch'],
            $js_version,
            true
        );

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
