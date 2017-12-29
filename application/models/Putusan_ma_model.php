<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Putusan_ma_model extends MY_Model {
    
    protected $table = 'mahkamahagung';
    protected $primary_key = 'ma_id';
    protected $create_date = 'ma_create';
    protected $update_date = 'ma_update';
    
    function __construct()
    {
        parent::__construct();
    }

    function get_publish_by($find, $key)
    {
        $this->db->where($find, $key);
        $this->db->where('ma_status', 3);

        return $this->db->get($this->table)->row_array();
    }

    function get_top_view($limit = 10)
    {
        $this->db->where('ma_status', 3);
        $this->db->order_by('ma_view', 'desc');
        $this->db->limit($limit);

        return $this->db->get($this->table)->result_array();
    }

    function get_top_download($limit = 10)
    {
        $this->db->where('ma_status', 3);
        $this->db->order_by('ma_download', 'desc');
        $this->db->limit($limit);

        return $this->db->get($this->table)->result_array();
    }

    function get_search_result_perpage($terms, $search_nomor, $search_tahun, $search_method, $search_sort, $search_order, $page, $perpage)
    {
        $start = ($page-1)*$perpage;
        
        if($search_tahun == '0000') $search_tahun = false;
        if($search_nomor == '0') $search_nomor = false;
        if($terms == 'semua') $terms = false;

        if($search_sort == 'tahun') $search_sort = 'ma_year';
        if($search_sort == 'nomor') $search_sort = 'ma_number';

        if($terms)
        {
            if($search_method == 'kalimat')
            {
                $where = "(ma_content like '% $terms %')";
            }
            if($search_method == 'atau')
            {
                $where = "MATCH (ma_content) AGAINST ('$terms' in boolean mode)";
            }
            if($search_method == 'dan')
            {
                $terms = trim($terms);
                $terms = preg_replace('!\s+!', ' ', $terms);
                $terms = str_replace(' ', ' +', $terms);
                $terms = '+'.$terms;
                $where = "MATCH (ma_content) AGAINST ('$terms' in boolean mode)";
            }

            $this->db->where($where);
        }
        $this->db->where('ma_status', 3);

        
        if(!empty($search_tahun)) { 
            if(is_array($search_tahun)) {
                $this->db->group_start();
                $i = 1;
                foreach($search_tahun as $eachtahun) {
                    if($i == 1) $this->db->where('ma_year', $eachtahun);
                    else $this->db->or_where('ma_year', $eachtahun);
                    $i++;
                }
                $this->db->group_end();
            } else {
                $this->db->where('ma_year', $search_tahun);
            }
        }

        if($search_nomor) $this->db->like('ma_number', $search_nomor, 'after');

        $this->db->order_by($search_sort,  $search_order);
        $this->db->limit($perpage, $start);

        return $this->db->get($this->table)->result_array();
    }

    function get_search_result($terms, $search_nomor, $search_tahun, $search_method, $search_sort, $search_order)
    {
        if($search_tahun == '0000') $search_tahun = false;
        if($search_nomor == '0') $search_nomor = false;
        if($terms == 'semua') $terms = false;

        if($search_sort == 'tahun') $search_sort = 'ma_year';
        if($search_sort == 'nomor') $search_sort = 'ma_number';

        if($terms)
        {
            if($search_method == 'kalimat')
            {
                $where = "(ma_content like '% $terms %')";
            }
            if($search_method == 'atau')
            {
                $where = "MATCH (ma_content) AGAINST ('$terms')";
            }
            if($search_method == 'dan')
            {
                $terms = trim($terms);
                $terms = preg_replace('!\s+!', ' ', $terms);
                $terms = str_replace(' ', ' +', $terms);
                $terms = '+'.$terms;
                $where = "MATCH (ma_content) AGAINST ('$terms' in boolean mode)";
            }
            $this->db->where($where);
        }
        $this->db->where('ma_status', 3);

        if(!empty($search_tahun)) { 
            if(is_array($search_tahun)) {
                $this->db->group_start();
                $i = 1;
                foreach($search_tahun as $eachtahun) {
                    if($i == 1) $this->db->where('ma_year', $eachtahun);
                    else $this->db->or_where('ma_year', $eachtahun);
                    $i++;
                }
                $this->db->group_end();
            } else {
                $this->db->where('ma_year', $search_tahun);
            }
        }

        //if($search_nomor) $this->db->like('ma_number', $search_nomor, 'after');
        if($search_nomor) $this->db->like('ma_number', $search_nomor, 'after');

        $this->db->order_by($search_sort,  $search_order);

        return $this->db->get($this->table)->result_array();
    }

    function get_all_publish()
    {
        $this->db->where('ma_status', 3);
        $this->db->order_by('ma_id', 'desc');

        return $this->db->get($this->table)->result_array();
    }

    function get_all_publish_perpage($page, $perpage, $search_sort, $search_order)
    {
        if($search_sort == 'tahun') $search_sort = 'ma_year';
        if($search_sort == 'nomor') $search_sort = 'ma_number';

        $start = ($page-1)*$perpage;

        $this->db->where('ma_status', 3);
        $this->db->order_by($search_sort, $search_order);
        $this->db->limit($perpage, $start);

        return $this->db->get($this->table)->result_array();
    }
	
    function get_all_perpage($page, $perpage)
    {
        $start = ($page-1)*$perpage;
           
        $this->db->order_by('ma_year', 'desc');
        $this->db->limit($perpage, $start);

        return $this->db->get($this->table)->result_array();
    }
	
    function get_all_search_perpage($page, $perpage, $keyword)
    {
        $start = ($page-1)*$perpage;
           
        $this->db->like('ma_number', $keyword);
        $this->db->order_by('ma_year', 'asc');
        $this->db->limit($perpage, $start);

        return $this->db->get($this->table)->result_array();
    }

    function count()
    {
        $this->db->where('ma_status', 3);

        return $this->db->count_all_results($this->table);
    }

    function countall()
    {
        return $this->db->count_all_results($this->table);
    }

    function countallsearch($keyword)
    {
		$this->db->like('ma_number', $keyword);
        return $this->db->count_all_results($this->table);
    }

    function get_tahun_ma()
    {
        $this->db->select('ma_year');
        $this->db->where('ma_status', 3);
        $this->db->order_by('ma_year', 'asc');
        $this->db->group_by('ma_year');

        return $this->db->get($this->table)->result_array();
    }

    function get_latest_ma()
    {
        $this->db->select('ma_update');
        $this->db->where('ma_status', 3);
        $this->db->order_by('ma_update', 'desc');
        $this->db->limit(1);

        return $this->db->get($this->table)->row_array();
    }

    function get_terkait($terms)
    {
        $where1 = "ma_content like '% $terms %'";

        $this->db->where($where1);
        $this->db->where('ma_status', 3);
        $this->db->group_by('ma_id');
        $this->db->limit(10);

        return $this->db->get($this->table)->result_array();
    }

    function get_latest_document($limit = 2)
    {
        $this->db->where('ma_status', 3);
        $this->db->order_by('ma_create', 'desc');
        $this->db->limit($limit);

        return $this->db->get($this->table)->result_array();
    }

    function get_notif_new_document()
    {
        $this->db->where('ma_status', 3);
        $this->db->order_by('ma_create', 'desc');
        $this->db->limit(1);

        $result = $this->db->get($this->table)->row_array();

        $ma_create = $result['ma_create'];

        $this->db->where('ma_create', $ma_create);
        return $this->db->get($this->table)->result_array();
    }
}