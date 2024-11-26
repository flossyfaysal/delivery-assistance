<?php

namespace DeliveryAssistance\Admin;

class Settings {
    public function __construct() {
        add_action('admin_init', [$this, 'register_settings']);
    }

    public function register_settings() {
        register_setting(
            'delivery_assistance_settings_group',
            'delivery_assistance_options',
            [
                'sanitize_callback' => [$this, 'sanitize_options'],
            ]
        );
    }

    public function sanitize_options($input) {
        $output = [];
        $output['api_key'] = sanitize_text_field($input['api_key'] ?? '');
        $output['default_status'] = sanitize_text_field($input['default_status'] ?? '');

        return $output;
    }
}
