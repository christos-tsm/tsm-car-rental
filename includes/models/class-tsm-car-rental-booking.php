<?php
class TSM_Car_Rental_Booking
{
    public static function get_booking_by_id($id)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . "tsm_bookings";
        $booking = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $id));

        return $booking;
    }
}
