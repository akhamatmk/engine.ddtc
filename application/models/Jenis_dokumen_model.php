<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jenis_dokumen_model extends MY_Model {
    
    protected $table = 'jenis_dokumen';
    protected $primary_key = 'jenis_dokumen_id';
    protected $create_date = 'jenis_dokumen_create';
    protected $update_date = 'jenis_dokumen_update';
    
    function __construct()
    {
        parent::__construct();
    }

    function get_all_publish_order_by($order, $sort)
    {
        $this->db->where('jenis_dokumen_status', '1');
        $this->db->order_by($order, $sort);
        return $this->db->get($this->table)->result_array();
    }

    function get_jenis_dokumen_name_array($jenis_dokumen_url_array)
    {
        $i = 0;
        foreach($jenis_dokumen_url_array as $row)
        {
            $this->db->where('jenis_dokumen_url', $row);
            $result = $this->db->get($this->table)->row_array();

            $jenis_dokumen_name_array[] = $result['jenis_dokumen_name'];

            $i++;
        }

        return $jenis_dokumen_name_array;
    }
}