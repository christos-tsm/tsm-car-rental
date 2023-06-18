<?php

/**
 * Fired during plugin activation
 *
 * @link       https://https://github.com/christos-tsm/
 * @since      1.0.0
 *
 * @package    Tsm_Car_Rental
 * @subpackage Tsm_Car_Rental/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Tsm_Car_Rental
 * @subpackage Tsm_Car_Rental/includes
 * @author     Christos Tsamis <christosgsd@gmail.com>
 */
class Tsm_Car_Rental_Activator
{

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate()
	{
		require_once plugin_dir_path(__FILE__) . '../admin/class-tsm-car-rental-admin.php';
		$plugin_admin = new Tsm_Car_Rental_Admin('tsm-car-rental', '1.0.0');
		$plugin_admin->create_car_post_type();
		$plugin_admin->create_car_type_taxonomy();
		self::tsm_create_bookings_table();
		flush_rewrite_rules();
	}


	private static function tsm_create_bookings_table()
	{
		global $wpdb;

		$table_name = $wpdb->prefix . 'tsm_bookings';

		$charset_collate = $wpdb->get_charset_collate();
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

		$sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            car_id mediumint(9) NOT NULL,
            customer_id mediumint(9) NOT NULL,
            start_date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
            end_date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
            created_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
			status varchar(55) DEFAULT 'Pending' NOT NULL,
            PRIMARY KEY  (id)
        ) $charset_collate;";

		dbDelta($sql);
	}
}
