<?php
/**
 * Plugin Name: Delivery Assistance WP
 * Plugin URI: https://farbetterwp.com/delivery-assistance-wp
 * Description: A plugin to manage deliveries, including parcel and food delivery, with rider tracking and more.
 * Version: 1.0
 * Author: FarBetterWP
 * Author URI: https://farbetterwp.com
 * License: GPL2
 * Text Domain: delivery-assistance-wp
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Autoload classes
spl_autoload_register(function ($class) {
    $prefix = 'DeliveryAssistance\\';
    $base_dir = __DIR__ . '/includes/';
    $len = strlen($prefix);

    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

// Initialize the plugin
function delivery_assistance_init() {
    DeliveryAssistance\Plugin::get_instance();
}
add_action('plugins_loaded', 'delivery_assistance_init');
