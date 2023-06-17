<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://https://github.com/christos-tsm/
 * @since             1.0.0
 * @package           Tsm_Car_Rental
 *
 * @wordpress-plugin
 * Plugin Name:       TSM Car Rental
 * Plugin URI:        https://github.com/christos-tsm/tsm-car-rental
 * Description:       Complete car rental management solution - right from allowing businesses to easily add and manage their vehicle inventory, set prices based on various factors, manage bookings, and process payments, to giving customers an easy-to-use interface to browse available vehicles, book their desired vehicle, and make secure online payments. This comprehensive tool aims to seamlessly automate and streamline the end-to-end car rental process, ultimately enhancing efficiency and profitability for businesses, and improving the rental experience for customers.
 * Version:           1.0.0
 * Author:            Christos Tsamis
 * Author URI:        https://https://github.com/christos-tsm/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       tsm-car-rental
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'TSM_CAR_RENTAL_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-tsm-car-rental-activator.php
 */
function activate_tsm_car_rental() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-tsm-car-rental-activator.php';
	Tsm_Car_Rental_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-tsm-car-rental-deactivator.php
 */
function deactivate_tsm_car_rental() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-tsm-car-rental-deactivator.php';
	Tsm_Car_Rental_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_tsm_car_rental' );
register_deactivation_hook( __FILE__, 'deactivate_tsm_car_rental' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-tsm-car-rental.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_tsm_car_rental() {

	$plugin = new Tsm_Car_Rental();
	$plugin->run();

}
run_tsm_car_rental();
