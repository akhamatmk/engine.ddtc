<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Topik_model extends MY_Model {
    
    protected $table = 'topik';
    protected $primary_key = 'topik_id';
    protected $create_date = 'topik_create';
    protected $update_date = 'topik_update';
    
    function __construct()
    {
        parent::__construct();
    }

    function get_all_publish_order_by($order, $sort)
    {
        $this->db->where('topik_status', '1');
        $this->db->order_by($order, $sort);
        return $this->db->get($this->table)->result_array();
    }

    function get_topik_by_url($topik_url)
    {
        $this->db->where('topik_url', $topik_url);
        return $this->db->get($this->table)->row_array();
    }
}