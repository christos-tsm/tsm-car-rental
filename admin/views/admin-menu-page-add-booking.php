<div class="wrap">
    <h2>Bookings</h2>
    <form method="post" class="add-booking-form" action="<?php echo esc_html(admin_url('admin-post.php')); ?>">
        <input type="hidden" name="action" value="tsm_add_booking">
        <label for="car_id">Car ID:</label>
        <input type="text" id="car_id" name="car_id">
        <label for="customer_name">Customer Name:</label>
        <input type="text" id="customer_name" name="customer_name">
        <label for="customer_email">Customer Email:</label>
        <input type="text" id="customer_email" name="customer_email">
        <label for="start_date">Start Date:</label>
        <input type="date" id="start_date" name="start_date">
        <label for="end_date">End Date:</label>
        <input type="date" id="end_date" name="end_date">
        <label for="status">Status:</label>
        <select id="status" name="status">
            <option value="confirmed">Confirmed</option>
            <option value="cancelled">Cancelled</option>
        </select>
        <?php wp_nonce_field('tsm_add_booking_nonce', 'tsm_add_booking_nonce_field'); ?>
        <input type="submit" value="Add Booking">
    </form>
</div>