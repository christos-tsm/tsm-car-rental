<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://https://github.com/christos-tsm/
 * @since      1.0.0
 *
 * @package    Tsm_Car_Rental
 * @subpackage Tsm_Car_Rental/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Tsm_Car_Rental
 * @subpackage Tsm_Car_Rental/includes
 * @author     Christos Tsamis <christosgsd@gmail.com>
 */
class Tsm_Car_Rental_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'tsm-car-rental',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
