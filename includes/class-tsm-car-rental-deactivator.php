<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://https://github.com/christos-tsm/
 * @since      1.0.0
 *
 * @package    Tsm_Car_Rental
 * @subpackage Tsm_Car_Rental/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Tsm_Car_Rental
 * @subpackage Tsm_Car_Rental/includes
 * @author     Christos Tsamis <christosgsd@gmail.com>
 */
class Tsm_Car_Rental_Deactivator
{

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate()
	{
		// Flush the rewrite rules
		flush_rewrite_rules();
	}
}
