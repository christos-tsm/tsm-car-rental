<?php
ob_start();
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
        $this->process_bulk_action();

        add_action('admin_init', array($this, 'process_action'));
    }

    public function get_columns()
    {
        return array(
            'id'         => __('ID', 'tsm'),
            'car_id'     => __('Car ID', 'tsm'),
            'start_date' => __('Start Date', 'tsm'),
            'end_date'   => __('End Date', 'tsm'),
            'customer_email' => __('Customer Email', 'tsm'),
            'customer_name' => __('Customer Name', 'tsm'),
            'status'     => __('Status', 'tsm')
        );
    }

    public function column_default($item, $column_name)
    {
        switch ($column_name) {
            case 'id':
            case 'car_id':
            case 'customer_email':
            case 'customer_name':
            case 'status':
                return $item[$column_name];
            case 'start_date':
            case 'end_date':
                // Create DateTime object from date string
                $date = DateTime::createFromFormat('Y-m-d H:i:s', $item[$column_name]);
                // Check if the date is valid
                if ($date) {
                    // Format the date and return it
                    return $date->format('d/m/Y');
                } else {
                    // Return original date string if it's not valid
                    return $item[$column_name];
                }
            default:
                return print_r($item, true); // For debugging purposes
        }
    }

    public function column_id($item)
    {
        $delete_nonce = wp_create_nonce('tsm_delete_booking');
        $actions = array(
            'edit'      => sprintf('<a href="?page=%s&action=%s&booking=%s">Edit</a>', $_REQUEST['page'], 'edit', $item['id']),
            'delete'    => sprintf('<a href="?page=%s&action=%s&booking=%s&_wpnonce=%s">Delete</a>', $_REQUEST['page'], 'delete', $item['id'], $delete_nonce),
        );
        return sprintf('%1$s %2$s', $item['id'], $this->row_actions($actions));
    }

    public function process_bulk_action()
    {
        if ('delete' === $this->current_action()) {
            $id = isset($_GET['booking']) ? $_GET['booking'] : null;
            // Verify the nonce.
            if (!isset($_GET['_wpnonce']) || !wp_verify_nonce($_GET['_wpnonce'], 'tsm_delete_booking')) {
                die('Sorry, your nonce did not verify.');
            }
            // Check user permissions.
            if (!current_user_can('manage_options')) {
                wp_die('You do not have sufficient permissions to access this page.');
            }
            if ($id) {
                global $wpdb;
                $table_name = $wpdb->prefix . "tsm_bookings";
                $wpdb->delete($table_name, array('id' => $id));
                // Redirect back to the bookings list
                $output = ob_get_clean();
                error_log("Output before redirect: $output");
                wp_redirect(admin_url('admin.php?page=tsm-bookings'));
                exit;
            }
        }
        // Check if an edit action has been triggered...
        if ('edit' === $this->current_action()) {
            $id = isset($_GET['booking']) ? $_GET['booking'] : null;

            if ($id) {
                // Redirect to your booking edit page, using the $id of the booking.

                wp_redirect(admin_url('admin.php?page=tsm-add-booking&id=' . $id));
                exit;
            }
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

        if (!empty($_REQUEST['s'])) {
            $sql .= ' WHERE customer_email LIKE \'%' . esc_sql($_REQUEST['s']) . '%\'';
        }

        if (!empty($_REQUEST['orderby'])) {
            $sql .= ' ORDER BY ' . esc_sql($_REQUEST['orderby']);
            $sql .= !empty($_REQUEST['order']) ? ' ' . esc_sql($_REQUEST['order']) : ' ASC';
        }

        $sql .= " LIMIT $per_page";
        $sql .= ' OFFSET ' . ($page_number - 1) * $per_page;

        $result = $wpdb->get_results($sql, 'ARRAY_A');

        return $result;
    }

    // Avoid headers already sent issue
    public function process_action()
    {
        $action = $this->current_action();
        if ($action === 'delete') {
            $this->delete_booking(absint($_GET['booking']));
            wp_redirect(admin_url('admin.php?page=tsm-bookings'));
            exit;
        }
    }
}
