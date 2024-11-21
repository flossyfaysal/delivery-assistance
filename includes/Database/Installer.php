<?php

namespace DeliveryAssistance\Database;

class Installer {
    public static function install() {
        global $wpdb;

        $table_name = $wpdb->prefix . 'deliveries';
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
            id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            delivery_id VARCHAR(255) NOT NULL,
            status VARCHAR(50) DEFAULT 'pending',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) $charset_collate;";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta($sql);
    }

    public static function uninstall() {
        // Optional: Drop the table if necessary
    }
}
