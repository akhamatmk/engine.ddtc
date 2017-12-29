<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kelompok_model extends MY_Model {
    
    protected $table = 'kelompok';
    protected $primary_key = 'idk';
    
    function __construct()
    {
        parent::__construct();
    }

    function get_all_publish_order_by($order, $sort)
    {
        $this->db->where('status', '1');
        $this->db->order_by($order, $sort);
        return $this->db->get($this->table)->result_array();
    }

    function get_kelompok_array($kelompok_url_array)
    {
        $i = 0;
        foreach($kelompok_url_array as $row)
        {
            $this->db->where('kelompok_url', $row);
            $result = $this->db->get($this->table)->row_array();

            $kelompok_array[] = $result['kelompok'];

            $i++;
        }

        return $kelompok_array;
    }
}