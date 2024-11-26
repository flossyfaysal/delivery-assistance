<?php
namespace DeliveryAssistance\RestAPI;

class SettingsAPI {
    public function __construct() {
        add_action( 'rest_api_init', array( $this, 'register_routes' ) );
    }

    public function register_routes() {
        register_rest_route(
            'delivery-assistance/v1',
            '/save-settings',
            array(
                'methods'             => 'POST',
                'callback'            => array( $this, 'delivery_assistance_save_settings' ),
                'permission_callback' => array( $this, 'check_permissions' ),
            )
        );
    }

    public function check_permissions() {
        return current_user_can( 'manage_options' );
    }

    public function delivery_assistance_save_settings( \WP_REST_Request $request ) {
        $options = $request->get_param( 'deliver_assistance_option' );

        if ( ! $options || ! is_array( $options ) ) {
            return new \WP_Error( 'invalid_data', 'Invalid settings data.', array( 'status' => 400 ) );
        }

        update_option( 'delivery_assistance_options', $options );

        $saved_options = get_option( 'delivery_assistance_options', array() );
        return new \WP_REST_Response( array( 'data' => $saved_options ), 200 );
    }
}

