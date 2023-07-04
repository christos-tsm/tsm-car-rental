<?php
$edit_mode = false;
$booking = null;
if (isset($_GET['id']) && !empty($_GET['id'])) {
    require_once dirname(dirname(plugin_dir_path(__FILE__))) . '/includes/models/class-tsm-car-rental-booking.php';
    $edit_mode = true;
    $id = intval($_GET['id']);
    $booking = TSM_Car_Rental_Booking::get_booking_by_id($id);
}

$args = array(
    'post_type' => 'tsm_car',
    'posts_per_page' => -1
);
$cars = get_posts($args);
?>
<div class="wrap">
    <h2>Bookings</h2>
    <form method="post" class="add-booking-form" action="<?php echo esc_html(admin_url('admin-post.php')); ?>">
        <input type="hidden" name="action" value="tsm_add_booking">
        <div class="tsm-booking-form-row">
            <div class="tsm-input-container">
                <label for="car_id">Car:</label>
                <select name="car_id" id="car_id">
                    <?php foreach ($cars as $car) : ?>
                        <option value="<?php echo $car->ID; ?>" <?php if ($edit_mode && $booking->car_id == $car->ID) echo 'selected="selected"'; ?>><?php echo get_the_title($car->ID); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="tsm-booking-form-row">
            <div class="tsm-input-container">
                <label for="customer_name">Customer Name:</label>
                <input type="text" id="customer_name" name="customer_name" value="<?php if ($edit_mode) echo $booking->customer_name; ?>">
            </div>
            <div class="tsm-input-container">
                <label for="customer_email">Customer Email:</label>
                <input type="text" id="customer_email" name="customer_email" value="<?php if ($edit_mode) echo $booking->customer_email; ?>">
            </div>
        </div>
        <div class="tsm-booking-form-row">
            <div class="tsm-input-container">
                <label for="start_date">Start Date:</label>
                <input type="date" id="start_date" name="start_date" value="<?php if ($edit_mode) echo $booking->start_date; ?>">
            </div>
            <div class="tsm-input-container">
                <label for="end_date">End Date:</label>
                <input type="date" id="end_date" name="end_date" value="<?php if ($edit_mode) echo $booking->end_date; ?>">
            </div>
        </div>
        <div class="tsm-booking-form-row">
            <div class="tsm-input-container">
                <label for="status">Status:</label>
                <select id="status" name="status">
                    <option value="pending" <?php if ($edit_mode && $booking->status == 'pending') echo 'selected="selected"'; ?>>Pending</option>
                    <option value="confirmed" <?php if ($edit_mode && $booking->status == 'confirmed') echo 'selected="selected"'; ?>>Confirmed</option>
                    <option value="cancelled" <?php if ($edit_mode && $booking->status == 'cancelled') echo 'selected="selected"'; ?>>Cancelled</option>
                </select>
            </div>
        </div>
        <?php wp_nonce_field('tsm_add_booking_nonce', 'tsm_add_booking_nonce_field'); ?>
        <input type="submit" class="button button-primary button-large" value="<?php echo $edit_mode ? 'Update Booking' : 'Add Booking'; ?>">
        <?php if ($edit_mode) echo '<input type="hidden" name="id" value="' . $id . '">'; ?>
    </form>
</div>