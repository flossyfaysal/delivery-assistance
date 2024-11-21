<?php

namespace DeliveryAssistance;

class Plugin {
    private static $instance = null;

    // Singleton instance
    public static function get_instance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        $this->define_constants();
        $this->load_dependencies();
        $this->initialize_hooks();
    }

    private function define_constants() {
        define('DELIVERY_ASSISTANCE_PLUGIN_DIR', plugin_dir_path(__DIR__));
        define('DELIVERY_ASSISTANCE_PLUGIN_URL', plugin_dir_url(__DIR__));
        define('DELIVERY_ASSISTANCE_VERSION', '1.0.0');
    }

    private function load_dependencies() {
        new Admin\Menu();
        new Admin\Settings();
        new Frontend\Enqueue();
        new Database\Installer();
       new RestAPI\SettingsAPI();
    }

    private function initialize_hooks() {
        register_activation_hook(DELIVERY_ASSISTANCE_PLUGIN_DIR . 'delivery-assistance-wp.php', ['DeliveryAssistance\Database\Installer', 'install']);
        register_deactivation_hook(DELIVERY_ASSISTANCE_PLUGIN_DIR . 'delivery-assistance-wp.php', ['DeliveryAssistance\Database\Installer', 'uninstall']);
    }
}
