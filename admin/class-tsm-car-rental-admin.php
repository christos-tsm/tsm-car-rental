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
				'has_archive' => true,
				'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'),
				'show_in_rest' => true,
				'menu_icon'   => 'dashicons-car',
			)
		);
	}
}
