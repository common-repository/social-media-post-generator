<?php
// WP_List_Table is not loaded automatically so we need to load it in our application
if (!class_exists('WP_List_Table')) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

class SMPG_Wp_List_Table extends WP_List_Table
{

    function __construct()
    {
        // Set parent defaults.
        parent::__construct(array(
            'singular' => 'movie',     // Singular name of the listed records.
            'plural'   => 'movies',    // Plural name of the listed records.
            'ajax'     => false,       // Does this table support ajax?
        ));
    }
    /**
     * Prepare the items for the table to process
     *
     * @return Void
     */
    public function prepare_items()
    {
        $columns = $this->get_columns();
        $hidden = $this->get_hidden_columns();
        $sortable = $this->get_sortable_columns();

        $data = $this->table_data();
        usort($data, array(&$this, 'sort_data'));

        $perPage = 7;
        $currentPage = $this->get_pagenum();
        $totalItems = count($data);

        $this->set_pagination_args(array(
            'total_items' => $totalItems,
            'per_page'    => $perPage
        ));

        $data = array_slice($data, (($currentPage - 1) * $perPage), $perPage);

        $this->_column_headers = array($columns, $hidden, $sortable);
        $this->items = $data;
    }

    /**
     * Override the parent columns method. Defines the columns to use in your listing table
     *
     * @return Array
     */
    public function get_columns()
    {
        $columns = array(
            //  'id'          => 'ID',
            'featuredImage' => 'Image',
            'title'       => 'Title',
            'date'        => 'Date',
        );

        return $columns;
    }

    /**
     * Define which columns are hidden
     *
     * @return Array
     */
    public function get_hidden_columns()
    {
        return array();
    }

    /**
     * Define the sortable columns
     *
     * @return Array
     */
    public function get_sortable_columns()
    {
        return array('title' => array('title', false));
    }

    /**
     * Get the table data
     *
     * @return Array
     */
    private function table_data()
    {
        $data = array();
        $posts = get_posts();

        foreach ($posts as $p) {

            array_push($data, array(
                'id'          => $p->ID,
                'title'       => $p->post_title . '<br><a href="?page=social-media-generator&tab=generate&postId=' . $p->ID . '">Generate Images</a>',
                'date'        => $p->post_date,
                'featuredImage'    => get_the_post_thumbnail($p),
            ));
        }
        return $data;
    }

    /**
     * Define what data to show on each column of the table
     *
     * @param  Array $item        Data
     * @param  String $column_name - Current column name
     *
     * @return Mixed
     */
    public function column_default($item, $column_name)
    {
        switch ($column_name) {
            case 'id':
            case 'title':
            case 'date':
            case 'featuredImage':
                return $item[$column_name];

            default:
                return print_r($item, true);
        }
    }
    /**
     * Allows you to sort the data by the variables set in the $_GET
     *
     * @return Mixed
     */
    private function sort_data($a, $b)
    {
        // Set defaults
        $orderby = 'title';
        $order = 'asc';

        // If orderby is set, use this as the sort column
        if (!empty($_GET['orderby'])) {
            $orderby = sanitize_sql_orderby($_GET['orderby']);
        }

        // If order is set use this as the order
        if (!empty($_GET['order'])) {
            $order = sanitize_sql_orderby($_GET['order']);
        }


        $result = strcmp($a[$orderby], $b[$orderby]);

        if ($order === 'asc') {
            return $result;
        }

        return -$result;
    }
}
