<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://https://github.com/christos-tsm/
 * @since      1.0.0
 *
 * @package    Tsm_Car_Rental
 * @subpackage Tsm_Car_Rental/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Tsm_Car_Rental
 * @subpackage Tsm_Car_Rental/admin
 * @author     Christos Tsamis <christosgsd@gmail.com>
 */

require_once plugin_dir_path(__FILE__) . 'class-tsm-booking-list.php';

class Tsm_Car_Rental_Admin
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{
		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Tsm_Car_Rental_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Tsm_Car_Rental_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_style('flatpickr-admin-styles', 'https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css', array(), null, 'all');
		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/tsm-car-rental-admin.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Tsm_Car_Rental_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Tsm_Car_Rental_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		// Get the page query parameter
		$page = isset($_GET['page']) ? $_GET['page'] : null;

		// Check if the current page is tsm-add-booking
		if ($page === 'tsm-add-booking') {
			wp_enqueue_script('flatpickr-admin-script', 'https://cdn.jsdelivr.net/npm/flatpickr', array(), null, false);
		}
		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/tsm-car-rental-admin.js', array('jquery'), $this->version, false);
	}

	/**
	 * Create custom post type for Cars
	 * @since 1.0.0
	 */
	public function create_car_post_type()
	{
		register_post_type(
			'tsm_car',
			array(
				'labels' => array(
					'name' => __('Cars'),
					'singular_name' => __('Car')
				),
				'public' => true,
				'has_archive' => false,
				'supports' => array('title', 'editor', 'thumbnail'),
				'show_in_rest' => true,
				'menu_icon'   => 'dashicons-car',
			)
		);
	}

	/**
	 * Create custom taxonomy for post type Cars
	 * @since 1.0.0
	 */
	public function create_car_type_taxonomy()
	{
		register_taxonomy(
			'car_type',
			'tsm_car',
			array(
				'label' => __('Car Type'),
				'rewrite' => array('slug' => 'car_type'),
				'hierarchical' => true,
				'show_in_rest' => true,
			)
		);
	}

	/**
	 * Create admin menu pages
	 * @since 1.0.0
	 */
	public function add_plugin_admin_menu()
	{
		// Main menu page
		add_menu_page(
			__('Car Settings', 'tsm-car-rental'), // page title
			__('Car Rental', 'tsm-car-rental'), // menu title
			'manage_options', // capability
			'tsm-car-settings', // menu slug
			array($this, 'display_plugin_setup_page'), // function
			'dashicons-admin-generic', // icon url
			99 // position
		);

		// Bookings submenu page
		add_submenu_page(
			'tsm-car-settings', // parent slug
			__('Bookings', 'tsm-car-rental'), // page title
			__('Bookings', 'tsm-car-rental'), // menu title
			'manage_options', // capability
			'tsm-bookings', // menu slug
			array($this, 'display_bookings_page') // function
		);

		add_submenu_page(
			'tsm-car-settings', // parent slug
			__('Add Booking', 'tsm-car-rental'), // page title
			__('Add Booking', 'tsm-car-rental'), // menu title
			'manage_options', // capability
			'tsm-add-booking', // menu slug
			array($this, 'display_add_booking_page') // function
		);
	}

	public function display_plugin_setup_page()
	{
		include_once('views/admin-menu-page-settings.php');
	}

	public function display_add_booking_page()
	{
		include_once('views/admin-menu-page-add-booking.php');
	}

	public function display_bookings_page()
	{
		$bookingsListTable = new TSM_Booking_List();
		$bookingsListTable->prepare_items();
		include_once('views/admin-menu-page-bookings.php');
	}

	/**
	 * Add booking from settings page 
	 * @since 1.0.0
	 */
	public function handle_add_booking()
	{
		// Check the nonce for security
		check_admin_referer('tsm_add_booking_nonce', 'tsm_add_booking_nonce_field');

		// Get the form fields
		$car_id = intval($_POST['car_id']);
		$customer_name = sanitize_text_field($_POST['customer_name']);
		$customer_email = sanitize_email($_POST['customer_email']);
		$start_date = sanitize_text_field($_POST['start_date']);
		$end_date = sanitize_text_field($_POST['end_date']);

		$start_date_with_time = $start_date . ' 00:00:00';
		$end_date_with_time = $end_date . ' 00:00:00';

		$status = sanitize_text_field($_POST['status']);

		// Insert the new booking into the database
		global $wpdb;
		$table_name = $wpdb->prefix . "tsm_bookings";
		$result = $wpdb->insert(
			$table_name,
			array(
				'car_id' => $car_id,
				'customer_name' => $customer_name,
				'customer_id' => 0,
				'customer_email' => $customer_email,
				'start_date' => $start_date_with_time,
				'end_date' => $end_date_with_time,
				'status' => $status,
			)
		);

		if ($result === false) {
			error_log("Database insert operation failed: " . $wpdb->last_error);
		}

		// Redirect back to the bookings list
		wp_redirect(admin_url('admin.php?page=tsm-bookings'));
		exit;
	}
}
