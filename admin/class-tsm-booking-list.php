<?php
if (!class_exists('WP_List_Table')) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

class TSM_Booking_List extends WP_List_Table
{

    public function __construct()
    {
        parent::__construct(array(
            'singular' => __('Booking', 'tsm'),
            'plural'   => __('Bookings', 'tsm'),
            'ajax'     => false
        ));
    }

    public function get_columns()
    {
        // Define columns for the table
        return array(
            'id'         => __('ID', 'tsm'),
            'car_id'     => __('Car ID', 'tsm'),
            'start_date' => __('Start Date', 'tsm'),
            'end_date'   => __('End Date', 'tsm'),
            'status'     => __('Status', 'tsm')
        );
    }

    public function column_default($item, $column_name)
    {
        switch ($column_name) {
            case 'id':
            case 'car_id':
            case 'start_date':
            case 'end_date':
            case 'status':
                return $item[$column_name];
            default:
                return print_r($item, true); // For debugging purposes
        }
    }

    public function prepare_items()
    {
        $columns  = $this->get_columns();
        $hidden   = array(); // Define hidden columns if any
        $sortable = array(); // Define sortable columns if any
        $this->_column_headers = array($columns, $hidden, $sortable);

        $per_page     = 12;
        $current_page = $this->get_pagenum();
        $total_items  = $this->record_count();

        $this->set_pagination_args([
            'total_items' => $total_items, // Total number of bookings
            'per_page'    => $per_page // Items per page
        ]);

        $this->items = $this->get_bookings($per_page, $current_page);
    }

    public function record_count()
    {
        global $wpdb;

        $sql = "SELECT COUNT(*) FROM {$wpdb->prefix}tsm_bookings";

        return $wpdb->get_var($sql);
    }

    public function get_bookings($per_page = 5, $page_number = 1)
    {
        global $wpdb;

        $sql = "SELECT * FROM {$wpdb->prefix}tsm_bookings";

        if (!empty($_REQUEST['orderby'])) {
            $sql .= ' ORDER BY ' . esc_sql($_REQUEST['orderby']);
            $sql .= !empty($_REQUEST['order']) ? ' ' . esc_sql($_REQUEST['order']) : ' ASC';
        }

        $sql .= " LIMIT $per_page";
        $sql .= ' OFFSET ' . ($page_number - 1) * $per_page;

        $result = $wpdb->get_results($sql, 'ARRAY_A');

        return $result;
    }
}
