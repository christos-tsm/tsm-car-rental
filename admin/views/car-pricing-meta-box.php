<!-- Base price -->
<p>
    <label for="tsm_base_price"><?php _e('Base price per day', 'tsm-car-rental'); ?></label>
    <input type="number" name="tsm_base_price" id="tsm_base_price" value="<?php echo esc_attr($base_price); ?>" />
</p>

<!-- Adjust price -->
<p>
    <label for="tsm_adjust_price"><?php _e('Adjust price for certain periods?', 'tsm-car-rental'); ?></label>
    <input type="checkbox" name="tsm_adjust_price" id="tsm_adjust_price" value="1" <?php checked($adjust_price, '1'); ?> />
</p>

<!-- Price periods (simplified) -->
<div id="tsm_price_periods">
    <?php foreach ($price_periods as $i => $period) : ?>
        <div class="tsm_price_period">
            <h4><?php printf(__('Period %d', 'tsm-car-rental'), $i + 1); ?></h4>
            <p>
                <label for="tsm_price_periods[<?php echo $i; ?>][start_date]"><?php _e('Start date', 'tsm-car-rental'); ?></label><br>
                <input type="date" name="tsm_price_periods[<?php echo $i; ?>][start_date]" id="tsm_price_periods[<?php echo $i; ?>][start_date]" value="<?php echo esc_attr($period['start_date']); ?>" />
            </p>
            <p>
                <label for="tsm_price_periods[<?php echo $i; ?>][end_date]"><?php _e('End date', 'tsm-car-rental'); ?></label><br>
                <input type="date" name="tsm_price_periods[<?php echo $i; ?>][end_date]" id="tsm_price_periods[<?php echo $i; ?>][end_date]" value="<?php echo esc_attr($period['end_date']); ?>" />
            </p>
            <p>
                <label for="tsm_price_periods[<?php echo $i; ?>][daily_price]"><?php _e('Daily price', 'tsm-car-rental'); ?></label><br>
                <input type="number" name="tsm_price_periods[<?php echo $i; ?>][daily_price]" id="tsm_price_periods[<?php echo $i; ?>][daily_price]" value="<?php echo esc_attr($period['daily_price']); ?>" />
            </p>
        </div>
    <?php endforeach; ?>
</div>
<button id="tsm_add_price_period" type="button" class="wp-core-ui button-primary"><?php _e('Add Price Period', 'tsm-car-rental'); ?></button>
<script type="text/javascript">
    jQuery(document).ready(function($) {
        var periodIndex = <?php echo count($price_periods); ?>;

        $('#tsm_add_price_period').click(function() {
            var periodHtml = '<div class="tsm_price_period">' +
                '<h4>Period ' + (periodIndex + 1) + '</h4>' +
                '<p>' +
                '<label for="tsm_price_periods[' + periodIndex + '][start_date]">Start date</label><br>' +
                '<input type="date" name="tsm_price_periods[' + periodIndex + '][start_date]" id="tsm_price_periods[' + periodIndex + '][start_date]" value="" />' +
                '</p>' +
                '<p>' +
                '<label for="tsm_price_periods[' + periodIndex + '][end_date]">End date</label><br>' +
                '<input type="date" name="tsm_price_periods[' + periodIndex + '][end_date]" id="tsm_price_periods[' + periodIndex + '][end_date]" value="" />' +
                '</p>' +
                '<p>' +
                '<label for="tsm_price_periods[' + periodIndex + '][daily_price]">Daily price</label><br>' +
                '<input type="number" name="tsm_price_periods[' + periodIndex + '][daily_price]" id="tsm_price_periods[' + periodIndex + '][daily_price]" value="" />' +
                '</p>' +
                '</div>';

            $('#tsm_price_periods').append(periodHtml);

            periodIndex++;
        });
    });
</script>