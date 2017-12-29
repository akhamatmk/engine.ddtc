<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master_listjenis_model extends MY_Model {
    
    protected $table = 'master_listjenis';
    protected $primary_key = 'IDJenis';
    
    function __construct()
    {
        parent::__construct();
    }

    function get_all_publish_order_by($order, $sort, $doc)
    {
        $this->db->where($doc, 1);
        $this->db->order_by($order, $sort);
        return $this->db->get($this->table)->result_array();
    }
}