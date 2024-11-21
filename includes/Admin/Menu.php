<?php

namespace DeliveryAssistance\Admin;

class Menu {
    public function __construct() {
        add_action('admin_menu', [$this, 'add_admin_menu']);
    }

    public function add_admin_menu() {

        add_menu_page(
            esc_html__('DeliveryWP', 'delivery-assistance-wp'),
            esc_html__('DeliveryWP', 'delivery-assistance-wp'),
            'manage_options',
            'delivery-assistance',
            [$this, 'admin_page_content'],
            'dashicons-buddicons-activity',
            25
        );
        
        add_submenu_page(
            'delivery-assistance',
            esc_html__('Settings', 'delivery-assistance-wp'),
            esc_html__('Settings', 'delivery-assistance-wp'),
            'manage_options',
            'delivery-assistance-settings',
            [$this, 'settings_page_content']
        );
    }

    public function admin_page_content() {
        ?>
        <div class="wrap">
            <h1><?php echo esc_html__('Delivery Assistance', 'delivery-assistance-wp'); ?></h1>
            <p><?php echo esc_html__('Welcome to the Delivery Assistance WP plugin! Manage deliveries, riders, and more here.', 'delivery-assistance-wp'); ?></p>
        </div>
        <?php
    }

    public function settings_page_content() {
        ?>
        <div id="delivery-assistance-settings-app"></div>
        <?php
    }
}
