<div class="tsm-admin-meta-boxes" style="display: flex; flex-wrap: wrap">
    <!-- A/C -->
    <p style="flex: 1">
        <label for="tsm_ac"><?php _e('A/C', 'tsm-car-rental'); ?></label><br>
        <input type="checkbox" name="tsm_ac" id="tsm_ac" value="1" <?php checked($ac, '1'); ?> />
    </p>

    <!-- Passengers -->
    <p style="flex: 1">
        <label for="tsm_passengers"><?php _e('Passengers', 'tsm-car-rental'); ?></label><br>
        <input type="number" name="tsm_passengers" id="tsm_passengers" value="<?php echo esc_attr($passengers); ?>" />
    </p>

    <!-- CC -->
    <p style="flex: 1">
        <label for="tsm_cc"><?php _e('CC', 'tsm-car-rental'); ?></label><br>
        <input type="number" name="tsm_cc" id="tsm_cc" value="<?php echo esc_attr($cc); ?>" />
    </p>

    <!-- HP -->
    <p style="flex: 1">
        <label for="tsm_hp"><?php _e('HP', 'tsm-car-rental'); ?></label><br>
        <input type="number" name="tsm_hp" id="tsm_hp" value="<?php echo esc_attr($hp); ?>" />
    </p>

    <!-- Car Model -->
    <p style="flex: 1">
        <label for="tsm_car_model"><?php _e('Car Model', 'tsm-car-rental'); ?></label><br>
        <input type="text" name="tsm_car_model" id="tsm_car_model" value="<?php echo esc_attr($car_model); ?>" />
    </p>

    <!-- Car Year -->
    <p style="flex: 1">
        <label for="tsm_car_year"><?php _e('Car Year', 'tsm-car-rental'); ?></label><br>
        <input type="number" name="tsm_car_year" id="tsm_car_year" value="<?php echo esc_attr($car_year); ?>" />
    </p>
</div>