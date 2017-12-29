<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class P3b_model extends MY_Model {
    
    protected $table = 'p3b';
    protected $primary_key = 'p3b_id';
    protected $create_date = 'p3b_create';
    protected $update_date = 'p3b_update';
    
    function __construct()
    {
        parent::__construct();
    }

    function get_publish_by($find, $key)
    {
        $this->db->where($find, $key);
        $this->db->where('p3b_status', 1);

        return $this->db->get($this->table)->row_array();
    }

    function get_top_view($limit = 10)
    {
        $this->db->where('p3b_status', 1);
        $this->db->order_by('p3b_view', 'desc');
        $this->db->limit($limit);

        return $this->db->get($this->table)->result_array();
    }

    function get_top_download($limit = 10)
    {
        $this->db->where('p3b_status', 1);
        $this->db->order_by('p3b_download', 'desc');
        $this->db->limit($limit);

        return $this->db->get($this->table)->result_array();
    }

    function get_by_country($p3b_country)
    {
        $this->db->where('p3b_country', $p3b_country);
        $this->db->where('p3b_status', 1);

        return $this->db->get($this->table)->row_array();
    }

    function get_all_publish()
    {
        $this->db->where('p3b_status', 1);
        $this->db->order_by('p3b_country', 'asc');

        return $this->db->get($this->table)->result_array();
    }

    function get_all_publish_perpage($page, $perpage)
    {
        $start = ($page-1)*$perpage;
           
        $this->db->where('p3b_status', 1);
        $this->db->order_by('p3b_country', 'asc');
        $this->db->limit($perpage, $start);

        return $this->db->get($this->table)->result_array();
    }
	
    function get_all_perpage($page, $perpage)
    {
        $start = ($page-1)*$perpage;
           
        //$this->db->where('p3b_status', 1);
        $this->db->order_by('p3b_country', 'asc');
        $this->db->limit($perpage, $start);

        return $this->db->get($this->table)->result_array();
    }
	
    function get_all_search_perpage($page, $perpage, $keyword)
    {
        $start = ($page-1)*$perpage;
           
        $this->db->like('p3b_country', $keyword);
        $this->db->order_by('p3b_country', 'asc');
        $this->db->limit($perpage, $start);

        return $this->db->get($this->table)->result_array();
    }

    function get_all_publish_country_name()
    {
        $this->db->select('p3b_country');
        $this->db->where('p3b_status', 1);
        $this->db->order_by('p3b_country', 'asc');
        $this->db->group_by('p3b_country');

        return $this->db->get($this->table)->result_array();
    }

    function get_latest_document($limit = 2)
    {
        $this->db->order_by('p3b_date_effective', 'desc');
        $this->db->limit($limit);

        return $this->db->get($this->table)->result_array();
    }

    function get_latest_p3b()
    {
        $this->db->select('p3b_update');
        $this->db->where('p3b_status', 1);
        $this->db->order_by('p3b_update', 'desc');
        $this->db->limit(1);

        return $this->db->get($this->table)->row_array();
    }

    function get_notif_new_document()
    {
        $this->db->where('p3b_status', 1);
        $this->db->order_by('p3b_create', 'desc');
        $this->db->limit(1);

        $result = $this->db->get($this->table)->row_array();

        $p3b_create = $result['p3b_create'];

        $this->db->where('p3b_create', $p3b_create);
        return $this->db->get($this->table)->result_array();
    }

    function count()
    {
        $this->db->where('p3b_status', 1);

        return $this->db->count_all_results($this->table);
    }

    function countall()
    {
        //$this->db->where('p3b_status', 1);

        return $this->db->count_all_results($this->table);
    }

    function countallsearch($keyword)
    {
        $this->db->like('p3b_country', $keyword);
        return $this->db->count_all_results($this->table);
    }
}