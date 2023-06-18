<?php
class TSM_Car_Rental_Meta_Boxes
{

    public function __construct()
    {
        add_action('add_meta_boxes', array($this, 'add_car_meta_boxes'));
        add_action('add_meta_boxes', array($this, 'add_pricing_meta_boxes'));
        add_action('save_post', array($this, 'save_car_meta_boxes'), 10, 2);
    }

    public function add_car_meta_boxes()
    {
        add_meta_box(
            'tsm_car_details',
            __('Car Details', 'tsm-car-rental'),
            array($this, 'render_car_details_meta_box'),
            'tsm_car',
            'normal',
            'default'
        );
    }

    public function add_pricing_meta_boxes()
    {
        add_meta_box(
            'tsm_car_pricing',
            __('Car Pricing', 'tsm-car-rental'),
            array($this, 'render_pricing_meta_box'),
            'tsm_car',
            'normal',
            'default'
        );
    }

    public function render_car_details_meta_box($post)
    {
        wp_nonce_field(basename(__FILE__), 'tsm_car_details_nonce');

        $ac = get_post_meta($post->ID, '_tsm_ac', true);
        $passengers = get_post_meta($post->ID, '_tsm_passengers', true);
        $cc = get_post_meta($post->ID, '_tsm_cc', true);
        $hp = get_post_meta($post->ID, '_tsm_hp', true);
        $car_model = get_post_meta($post->ID, '_tsm_car_model', true);
        $car_year = get_post_meta($post->ID, '_tsm_car_year', true);

        include plugin_dir_path(__FILE__) . '../admin/views/car-details-meta-box.php';
    }

    public function render_pricing_meta_box($post)
    {
        wp_nonce_field(basename(__FILE__), 'tsm_car_pricing_nonce');

        $base_price = get_post_meta($post->ID, '_tsm_base_price', true);
        $adjust_price = get_post_meta($post->ID, '_tsm_adjust_price', true);
        $adjust_price = $adjust_price ? $adjust_price : false;
        $price_periods = get_post_meta($post->ID, '_tsm_price_periods', true);
        $price_periods = is_array($price_periods) ? $price_periods : array();

        include plugin_dir_path(__FILE__) . '../admin/views/car-pricing-meta-box.php';
    }

    public function save_car_meta_boxes($post_id, $post)
    {
        if (!isset($_POST['tsm_car_details_nonce']) || !wp_verify_nonce($_POST['tsm_car_details_nonce'], basename(__FILE__))) {
            return $post_id;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return $post_id;
        }

        if ('tsm_car' === $_POST['post_type'] && current_user_can('edit_post', $post_id)) {
            update_post_meta($post_id, '_tsm_ac', sanitize_text_field($_POST['tsm_ac']));
            update_post_meta($post_id, '_tsm_passengers', sanitize_text_field($_POST['tsm_passengers']));
            update_post_meta($post_id, '_tsm_cc', sanitize_text_field($_POST['tsm_cc']));
            update_post_meta($post_id, '_tsm_hp', sanitize_text_field($_POST['tsm_hp']));
            update_post_meta($post_id, '_tsm_car_model', sanitize_text_field($_POST['tsm_car_model']));
            update_post_meta($post_id, '_tsm_car_year', sanitize_text_field($_POST['tsm_car_year']));

            update_post_meta($post_id, '_tsm_base_price', sanitize_text_field($_POST['tsm_base_price']));
            update_post_meta($post_id, '_tsm_adjust_price', isset($_POST['tsm_adjust_price']));
            if (isset($_POST['tsm_price_periods'])) {
                $price_periods_data = [];
                foreach ($_POST['tsm_price_periods'] as $period) {
                    $price_periods_data[] = [
                        'period_name'  => sanitize_text_field($period['period_name']),
                        'start_date' => sanitize_text_field($period['start_date']),
                        'end_date' => sanitize_text_field($period['end_date']),
                        'daily_price' => filter_var($period['daily_price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
                    ];
                }
                update_post_meta($post_id, '_tsm_price_periods', $price_periods_data);
            }
        }
    }
}

new TSM_Car_Rental_Meta_Boxes();
