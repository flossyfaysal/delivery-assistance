<?php

namespace DeliveryAssistance\Admin;

class CPT {
    
    public function __construct() {
        add_action('init', [$this, 'register_parcel_post_type']);
        add_action('add_meta_boxes', [$this, 'add_custom_meta_boxes']);
        add_action('save_post', [$this, 'save_parcel_meta_data']);
    }

    public function register_parcel_post_type() {
        register_post_type('parcel', [
            'labels' => [
                'name'          => __('Parcels', 'delivery-assistance'),
                'singular_name' => __('Parcel', 'delivery-assistance'),
                'add_new_item'  => __('Add New Parcel', 'delivery-assistance'),
                'edit_item'     => __('Edit Parcel', 'delivery-assistance'),
                'all_items'     => __('All Parcels', 'delivery-assistance'),
            ],
            'public'        => true,
            'show_ui'       => true,
            'has_archive'   => true,
            'menu_position' => 20,
            'menu_icon'     => 'dashicons-portfolio',
            'supports'      => ['title'], // Exclude post content
        ]);
    }
    
    public function add_custom_meta_boxes() {
        add_meta_box(
            'parcel_details',
            __('Parcel Details', 'delivery-assistance'),
            [$this, 'render_parcel_meta_boxes'],
            'parcel',
            'normal',
            'high'
        );
    }

    public function render_parcel_meta_boxes($post) {
        $meta_fields = [
            'recipient_details',
            'delivery_details',
            'parcel_type',
            'order_id',
            'delivery_area',
            'amount',
            'item_description',
            'note',
            'weight',
            'quantity',
        ];

        foreach ($meta_fields as $field) {
            ${$field} = get_post_meta($post->ID, $field, true);
        }

        wp_nonce_field('save_parcel_meta_data', 'parcel_meta_nonce');

        ?>
        <div class="parcel-meta-box">
            <div class="parcel-meta-box__field">
                <label for="recipient_details"><?php _e('Recipient Details', 'delivery-assistance'); ?></label>
                <input type="text" name="recipient_details" id="recipient_details" value="<?php echo esc_attr($recipient_details); ?>" class="parcel-meta-box__input">
            </div>
            <div class="parcel-meta-box__field">
                <label for="delivery_details"><?php _e('Delivery Details', 'delivery-assistance'); ?></label>
                <input type="text" name="delivery_details" id="delivery_details" value="<?php echo esc_attr($delivery_details); ?>" class="parcel-meta-box__input">
            </div>
            <div class="parcel-meta-box__field">
                <label for="parcel_type"><?php _e('Parcel Type', 'delivery-assistance'); ?></label>
                <input type="text" name="parcel_type" id="parcel_type" value="<?php echo esc_attr($parcel_type); ?>" class="parcel-meta-box__input">
            </div>
            <div class="parcel-meta-box__field">
                <label for="order_id"><?php _e('Order ID', 'delivery-assistance'); ?></label>
                <input type="text" name="order_id" id="order_id" value="<?php echo esc_attr($order_id); ?>" class="parcel-meta-box__input">
            </div>
            <div class="parcel-meta-box__field">
                <label for="delivery_area"><?php _e('Delivery Area', 'delivery-assistance'); ?></label>
                <input type="text" name="delivery_area" id="delivery_area" value="<?php echo esc_attr($delivery_area); ?>" class="parcel-meta-box__input">
            </div>
            <div class="parcel-meta-box__field">
                <label for="amount"><?php _e('Amount', 'delivery-assistance'); ?></label>
                <input type="number" name="amount" id="amount" value="<?php echo esc_attr($amount); ?>" class="parcel-meta-box__input">
            </div>
            <div class="parcel-meta-box__field">
                <label for="item_description"><?php _e('Item Description', 'delivery-assistance'); ?></label>
                <textarea name="item_description" id="item_description" class="parcel-meta-box__textarea"><?php echo esc_textarea($item_description); ?></textarea>
            </div>
            <div class="parcel-meta-box__field">
                <label for="note"><?php _e('Note', 'delivery-assistance'); ?></label>
                <textarea name="note" id="note" class="parcel-meta-box__textarea"><?php echo esc_textarea($note); ?></textarea>
            </div>
            <div class="parcel-meta-box__field">
                <label for="weight"><?php _e('Weight', 'delivery-assistance'); ?></label>
                <input type="number" step="0.01" name="weight" id="weight" value="<?php echo esc_attr($weight); ?>" class="parcel-meta-box__input">
            </div>
            <div class="parcel-meta-box__field">
                <label for="quantity"><?php _e('Quantity', 'delivery-assistance'); ?></label>
                <input type="number" name="quantity" id="quantity" value="<?php echo esc_attr($quantity); ?>" class="parcel-meta-box__input">
            </div>
        </div>

        <?php
    }

    public function save_parcel_meta_data($post_id) {
        if (!isset($_POST['parcel_meta_nonce']) || !wp_verify_nonce($_POST['parcel_meta_nonce'], 'save_parcel_meta_data')) {
            return;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        $meta_fields = [
            'recipient_details',
            'delivery_details',
            'parcel_type',
            'order_id',
            'delivery_area',
            'amount',
            'item_description',
            'note',
            'weight',
            'quantity',
        ];

        foreach ($meta_fields as $field) {
            if (isset($_POST[$field])) {
                update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
            }
        }
    }
    
}