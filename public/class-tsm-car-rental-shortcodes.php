<?php
class TSM_Car_Rental_Shortcodes
{
    public function tsm_car_rental_archive_shortcode($atts, $content = null)
    {
        // Get cars
        $cars = get_posts(array(
            'post_type' => 'tsm_car',
            'numberposts' => -1,
        ));

        // Start output buffering
        ob_start();

        // Loop through cars
        foreach ($cars as $car) {
            echo '<h2><a href="' . get_permalink($car->ID) . '">' . get_the_title($car->ID) . '</a></h2>';
        }

        // Return output buffer contents
        return ob_get_clean();
    }

    public function tsm_car_rental_single_shortcode($atts, $content = null)
    {
        // Extract attributes
        $atts = shortcode_atts(array(
            'id' => 0,
        ), $atts);

        // Get car
        $car = get_post($atts['id']);

        if (!$car || $car->post_type !== 'tsm_car') {
            return '';
        }

        // Start output buffering
        ob_start();

        // Display car
        echo '<h2>' . get_the_title($car->ID) . '</h2>';

        // Return output buffer contents
        return ob_get_clean();
    }

    public function tsm_car_rental_form_shortcode($atts, $content = null)
    {
        // Start output buffering
        ob_start();

?>
        <form method="POST" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
            <input type="hidden" name="action" value="tsm_car_rental_form">
            <label for="start_date">Start Date:</label><br>
            <input type="date" id="start_date" name="start_date"><br>
            <label for="end_date">End Date:</label><br>
            <input type="date" id="end_date" name="end_date"><br>
            <input type="submit" value="Submit">
        </form>
<?php

        // Return output buffer contents
        return ob_get_clean();
    }
}
