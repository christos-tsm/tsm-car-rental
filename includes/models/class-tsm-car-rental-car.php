<?php
class TSM_Car_Rental_Car
{
    private $post;

    public function __construct(WP_Post $post)
    {
        if ($post->post_type !== 'tsm_car') {
            throw new InvalidArgumentException('Invalid post type');
        }

        $this->post = $post;
    }

    public function get_id()
    {
        return $this->post->ID;
    }

    // Add your new custom fields here as get/set methods...

    public function get_AC()
    {
        return get_post_meta($this->post->ID, 'AC', true) === 'yes';
    }

    public function set_AC($AC)
    {
        update_post_meta($this->post->ID, 'AC', $AC ? 'yes' : 'no');
    }

    public function get_passengers()
    {
        return (int) get_post_meta($this->post->ID, 'passengers', true);
    }

    public function set_passengers($passengers)
    {
        update_post_meta($this->post->ID, 'passengers', $passengers);
    }

    // ... and so on for other fields

    public function get_car_type()
    {
        $terms = get_the_terms($this->post->ID, 'car_type');
        return is_array($terms) ? $terms[0]->name : '';
    }

    public function set_car_type($car_type)
    {
        wp_set_object_terms($this->post->ID, $car_type, 'car_type');
    }
}
