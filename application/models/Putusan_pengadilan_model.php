<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Putusan_pengadilan_model extends MY_Model {
    
    protected $table = 'putusanpengadilan';
    protected $primary_key = 'id';
    protected $create_date = 'created';
    protected $update_date = 'modified';
    
    function __construct()
    {
        parent::__construct();
    }

    function get_publish_by($find, $key)
    {
        $this->db->where($find, $key);
        $this->db->where('status', 1);

        return $this->db->get($this->table)->row_array();
    }

    function get_top_view($limit = 10)
    {
        $this->db->where('status', 1);
        $this->db->order_by('view', 'desc');
        $this->db->limit($limit);

        return $this->db->get($this->table)->result_array();
    }

    function get_top_download($limit = 10)
    {
        $this->db->where('status', 1);
        $this->db->order_by('download', 'desc');
        $this->db->limit($limit);

        return $this->db->get($this->table)->result_array();
    }

    function get_search_result_perpage($terms, $search_number, $search_jenis_pp, $search_tahun, $search_method, $search_sort, $search_order, $page, $perpage)
    {
        $start = ($page-1)*$perpage;
        
        if($search_tahun == '0000') $search_tahun = false;
        if($terms == 'semua') $terms = false;
        if($search_number == '0') $search_number = false;

        if($search_sort == 'tahun') $search_sort = 'tahun_keputusan';
        if($search_sort == 'nomor') $search_sort = 'nomor';

        if($search_jenis_pp[0] == 'semua-jenis-putusan-pengadilan-pajak')
        {
            if($terms)
            {
                if($search_method == 'kalimat')
                {
                    $where = "isi_putusan like '% $terms %'";
                    /*$where = "(pokok_sengketa like '% $terms %'";
                    $where .= " or menurut_terbanding like '% $terms %'";
                    $where .= " or menurut_pemohon like '% $terms %'";
                    $where .= " or menurut_majelis like '% $terms %'";
                    $where .= " or memperhatikan like '% $terms %'";
                    $where .= " or mengingat like '% $terms %'";
                    $where .= " or memutuskan like '% $terms %')";*/
                }
                if($search_method == 'atau')
                {
                    //$where = "MATCH (pokok_sengketa, menurut_terbanding, menurut_pemohon, menurut_majelis, memperhatikan, mengingat, memutuskan) AGAINST ('$terms' in boolean mode)";
                    $where = "MATCH (isi_putusan) AGAINST ('$terms' in boolean mode)";
                }
                if($search_method == 'dan')
                {
                    $terms = trim($terms);
                    $terms = preg_replace('!\s+!', ' ', $terms);
                    $terms = str_replace(' ', ' +', $terms);
                    $terms = '+'.$terms;
                    $where = "MATCH (isi_putusan) AGAINST ('$terms' in boolean mode)";
                }

                $this->db->where($where);
            }

            if(!empty($search_tahun)) { 
                if(is_array($search_tahun)) {
                    $this->db->group_start();
                    $i = 1;
                    foreach($search_tahun as $eachtahun) {
                        if($i == 1) $this->db->where('tahun_keputusan', $eachtahun);
                        else $this->db->or_where('tahun_keputusan', $eachtahun);
                        $i++;
                    }
                    $this->db->group_end();
                } else {
                    $this->db->where('tahun_keputusan', $search_tahun);
                }
            }

            $this->db->where('status', 1);

            if($search_number) $this->db->like('nomor', $search_number, 'both'); 

            $this->db->order_by($search_sort,  $search_order);
            $this->db->limit($perpage, $start);

            return $this->db->get($this->table)->result_array();
        }
        else
        {
            if($terms)
            {
                if($search_method == 'kalimat')
                {
                    $where = "isi_putusan like '% $terms %'";
                    /*$where = "(pokok_sengketa like '% $terms %'";
                    $where .= " or menurut_terbanding like '% $terms %'";
                    $where .= " or menurut_pemohon like '% $terms %'";
                    $where .= " or menurut_majelis like '% $terms %'";
                    $where .= " or memperhatikan like '% $terms %'";
                    $where .= " or mengingat like '% $terms %'";
                    $where .= " or memutuskan like '% $terms %')";*/
                }
                if($search_method == 'atau')
                {
                    //$where = "MATCH (pokok_sengketa, menurut_terbanding, menurut_pemohon, menurut_majelis, memperhatikan, mengingat, memutuskan) AGAINST ('$terms' in boolean mode)";
                    $where = "MATCH (isi_putusan) AGAINST ('$terms' in boolean mode)";
                }
                if($search_method == 'dan')
                {
                    $terms = trim($terms);
                    $terms = preg_replace('!\s+!', ' ', $terms);
                    $terms = str_replace(' ', ' +', $terms);
                    $terms = '+'.$terms;
                    $where = "MATCH (isi_putusan) AGAINST ('$terms' in boolean mode)";
                }

                $this->db->where($where);
            }

            //$search_jenis_pp = str_replace("-", " ", $search_jenis_pp);
            //$this->db->like('jenis_pajak', $search_jenis_pp, 'match');

            if(!empty($search_jenis_pp)) { 
                if(is_array($search_jenis_pp)) {
                    $this->db->group_start();
                    $i = 1;
                    foreach($search_jenis_pp as $eachjenis) {
                        $eachjenis = str_replace("-", " ", $eachjenis);
                        $eachjenis = str_replace("dan", "&", $eachjenis);
                        if(strpos($eachjenis, 'ayat') !== false) {
                            $eachjenis = str_replace('ayat ', 'ayat (', $eachjenis);
                            $eachjenis = $eachjenis . ')';
                        }
                        //$where2 = "MATCH (jenis_pajak) AGAINST ('$eachjenis' in boolean mode)";
                        $where2 = "jenis_pajak LIKE '%".$eachjenis."'";
                        if($i == 1) {
                            $this->db->where($where2);
                        } else {
                            $this->db->or_where($where2);
                        }
                        $i++;
                    }
                    $this->db->group_end();
                } else {
                    $search_jenis_pp = str_replace("-", " ", $search_jenis_pp);
                    $search_jenis_pp = str_replace("dan", "&", $search_jenis_pp);
                    if(strpos($search_jenis_pp, 'ayat') !== false) {
                        $search_jenis_pp = str_replace('ayat ', 'ayat (', $search_jenis_pp);
                        $search_jenis_pp = $search_jenis_pp . ')';
                    }
                    $where2 = "MATCH (jenis_pajak) AGAINST ('$search_jenis_pp' in boolean mode)";
                    $this->db->where($where2);
                }
            }

            if(!empty($search_tahun)) { 
                if(is_array($search_tahun)) {
                    $this->db->group_start();
                    $i = 1;
                    foreach($search_tahun as $eachtahun) {
                        if($i == 1) $this->db->where('tahun_keputusan', $eachtahun);
                        else $this->db->or_where('tahun_keputusan', $eachtahun);
                        $i++;
                    }
                    $this->db->group_end();
                } else {
                    $this->db->where('tahun_keputusan', $search_tahun);
                }
            }

            $this->db->where('status', 1);

            if($search_number) $this->db->like('nomor', $search_number, 'both'); 

            $this->db->order_by($search_sort,  $search_order);
            $this->db->limit($perpage, $start);

            return $this->db->get($this->table)->result_array();
        }
    }

    function get_search_result($terms, $search_number, $search_jenis_pp, $search_tahun, $search_method, $search_sort, $search_order)
    {
        if($search_tahun == '0000') $search_tahun = false;
        if($terms == 'semua') $terms = false;
        if($search_number == '0') $search_number = false;

        if($search_sort == 'tahun') $search_sort = 'tahun_keputusan';
        if($search_sort == 'nomor') $search_sort = 'nomor';

        if($search_jenis_pp[0] == 'semua-jenis-putusan-pengadilan-pajak')
        {
            if($terms)
            {
                if($search_method == 'kalimat')
                {
                    $where = "isi_putusan like '% $terms %'";
                    /*$where = "(pokok_sengketa like '% $terms %'";
                    $where .= " or menurut_terbanding like '% $terms %'";
                    $where .= " or menurut_pemohon like '% $terms %'";
                    $where .= " or menurut_majelis like '% $terms %'";
                    $where .= " or memperhatikan like '% $terms %'";
                    $where .= " or mengingat like '% $terms %'";
                    $where .= " or memutuskan like '% $terms %')";*/
                }
                if($search_method == 'atau')
                {
                    //$where = "MATCH (pokok_sengketa, menurut_terbanding, menurut_pemohon, menurut_majelis, memperhatikan, mengingat, memutuskan) AGAINST ('$terms' in boolean mode)";
                    $where = "MATCH (isi_putusan) AGAINST ('$terms' in boolean mode)";
                }
                if($search_method == 'dan')
                {
                    $terms = trim($terms);
                    $terms = preg_replace('!\s+!', ' ', $terms);
                    $terms = str_replace(' ', ' +', $terms);
                    $terms = '+'.$terms;
                    $where = "MATCH (isi_putusan) AGAINST ('$terms' in boolean mode)";
                }

                $this->db->where($where);
            }

            if(!empty($search_tahun)) { 
                if(is_array($search_tahun)) {
                    $this->db->group_start();
                    $i = 1;
                    foreach($search_tahun as $eachtahun) {
                        if($i == 1) $this->db->where('tahun_keputusan', $eachtahun);
                        else $this->db->or_where('tahun_keputusan', $eachtahun);
                        $i++;
                    }
                    $this->db->group_end();
                } else {
                    $this->db->where('tahun_keputusan', $search_tahun);
                }
            }

            $this->db->where('status', 1);

            if($search_number) $this->db->like('nomor', $search_number, 'both'); 

            $this->db->order_by($search_sort, 'desc');

            return $this->db->get($this->table)->result_array();
        }
        else
        {
            if($terms)
            {
                if($search_method == 'kalimat')
                {
                    $where = "isi_putusan like '% $terms %'";
                    /*$where = "(pokok_sengketa like '% $terms %'";
                    $where .= " or menurut_terbanding like '% $terms %'";
                    $where .= " or menurut_pemohon like '% $terms %'";
                    $where .= " or menurut_majelis like '% $terms %'";
                    $where .= " or memperhatikan like '% $terms %'";
                    $where .= " or mengingat like '% $terms %'";
                    $where .= " or memutuskan like '% $terms %')";*/
                }
                if($search_method == 'atau')
                {
                    //$where = "MATCH (pokok_sengketa, menurut_terbanding, menurut_pemohon, menurut_majelis, memperhatikan, mengingat, memutuskan) AGAINST ('$terms' in boolean mode)";
                    $where = "MATCH (isi_putusan) AGAINST ('$terms' in boolean mode)";
                }
                if($search_method == 'dan')
                {
                    $terms = trim($terms);
                    $terms = preg_replace('!\s+!', ' ', $terms);
                    $terms = str_replace(' ', ' +', $terms);
                    $terms = '+'.$terms;
                    $where = "MATCH (isi_putusan) AGAINST ('$terms' in boolean mode)";
                }

                $this->db->where($where);
            }

            //$search_jenis_pp = str_replace("-", " ", $search_jenis_pp);
            //$this->db->like('jenis_pajak', $search_jenis_pp, 'match');

            if(!empty($search_jenis_pp)) { 
                if(is_array($search_jenis_pp)) {
                    $this->db->group_start();
                    $i = 1;
                    foreach($search_jenis_pp as $eachjenis) {
                        $eachjenis = str_replace("-", " ", $eachjenis);
                        $eachjenis = str_replace("dan", "&", $eachjenis);
                        if(strpos($eachjenis, 'ayat') !== false) {
                            $eachjenis = str_replace('ayat ', 'ayat (', $eachjenis);
                            $eachjenis = $eachjenis . ')';
                        }
                        //$where2 = "MATCH (jenis_pajak) AGAINST ('$eachjenis' in boolean mode)";
                        $where2 = "jenis_pajak LIKE '%".$eachjenis."'";
                        if($i == 1) {
                            $this->db->where($where2);
                        } else {
                            $this->db->or_where($where2);
                        }
                        $i++;
                    }
                    $this->db->group_end();
                } else {
                    $search_jenis_pp = str_replace("-", " ", $search_jenis_pp);
                    $search_jenis_pp = str_replace("dan", "&", $search_jenis_pp);
                    if(strpos($search_jenis_pp, 'ayat') !== false) {
                        $search_jenis_pp = str_replace('ayat ', 'ayat (', $search_jenis_pp);
                        $search_jenis_pp = $search_jenis_pp . ')';
                    }
                    $where2 = "MATCH (jenis_pajak) AGAINST ('$search_jenis_pp' in boolean mode)";
                    $this->db->where($where2);
                }
            }

            if(!empty($search_tahun)) { 
                if(is_array($search_tahun)) {
                    $this->db->group_start();
                    $i = 1;
                    foreach($search_tahun as $eachtahun) {
                        if($i == 1) $this->db->where('tahun_keputusan', $eachtahun);
                        else $this->db->or_where('tahun_keputusan', $eachtahun);
                        $i++;
                    }
                    $this->db->group_end();
                } else {
                    $this->db->where('tahun_keputusan', $search_tahun);
                }
            }

            $this->db->where('status', 1);

            if($search_number) $this->db->like('nomor', $search_number, 'both'); 

            $this->db->order_by($search_sort, 'desc');

            return $this->db->get($this->table)->result_array();
        }
    }

    function get_all_publish()
    {
        $this->db->where('status', 1);
        $this->db->order_by('id', 'desc');

        return $this->db->get($this->table)->result_array();
    }

    function get_all_publish_perpage($page, $perpage, $search_sort, $search_order)
    {
        if($search_sort == 'tahun') $search_sort = 'tahun_keputusan';
        if($search_sort == 'nomor') $search_sort = 'nomor';

        $start = ($page-1)*$perpage;

        $this->db->where('status', 1);
        $this->db->order_by($search_sort, $search_order);
        $this->db->limit($perpage, $start);

        return $this->db->get($this->table)->result_array();
    }

    function get_all_perpage($page, $perpage)
    {
        $start = ($page-1)*$perpage;
           
        $this->db->order_by('tahun_keputusan', 'desc');
        $this->db->limit($perpage, $start);

        return $this->db->get($this->table)->result_array();
    }
	
    function get_all_search_perpage($page, $perpage, $keyword)
    {
        $start = ($page-1)*$perpage;
           
        $this->db->like('nomor', $keyword);
        $this->db->order_by('tahun_keputusan', 'asc');
        $this->db->limit($perpage, $start);

        return $this->db->get($this->table)->result_array();
    }

    function count()
    {
        $this->db->where('status', 1);

        return $this->db->count_all_results($this->table);
    }

    function countall()
    {
        return $this->db->count_all_results($this->table);
    }

    function countallsearch($keyword)
    {
		$this->db->like('nomor', $keyword);
        return $this->db->count_all_results($this->table);
    }
	
    function get_jenis_pp()
    {
        $this->db->select('jenis_pajak');
        $this->db->where('status', 1);
        $this->db->order_by('jenis_pajak', 'asc');
        $this->db->group_by('jenis_pajak');

        return $this->db->get($this->table)->result_array();
    }

    function get_tahun_pp()
    {
        $this->db->select('tahun_keputusan');
        $this->db->where('status', 1);
        $this->db->order_by('tahun_keputusan', 'asc');
        $this->db->group_by('tahun_keputusan');

        return $this->db->get($this->table)->result_array();
    }

    function get_latest_pp()
    {
        $this->db->select('modified');
        $this->db->where('status', 1);
        $this->db->order_by('modified', 'desc');
        $this->db->limit(1);

        return $this->db->get($this->table)->row_array();
    }

    function get_latest_document($limit = 2)
    {
        $this->db->where('status', 1);
        $this->db->order_by('tahun_keputusan', 'desc');
        $this->db->limit($limit);

        return $this->db->get($this->table)->result_array();
    }

    function get_notif_new_document()
    {
        $this->db->where('status', 1);
        $this->db->order_by('created', 'desc');
        $this->db->limit(1);

        $result = $this->db->get($this->table)->row_array();

        $created = $result['created'];

        $this->db->where('created', $created);
        return $this->db->get($this->table)->result_array();

        //return $this->db->get($this->table)->result_array();
    }

    function get_terkait($terms)
    {
        $where = "isi_putusan like '% $terms %'";

        $this->db->where($where);

        /*$where1 = "pokok_sengketa like '% $terms %'";
        $where2 = "menurut_terbanding like '% $terms %'";
        $where3 = "menurut_pemohon like '% $terms %'";
        $where4 = "menurut_majelis like '% $terms %'";
        $where5 = "memperhatikan like '% $terms %'";
        $where6 = "mengingat like '% $terms %'";
        $where7 = "memutuskan like '% $terms %'";

        $this->db->where($where1);
        $this->db->or_where($where2);
        $this->db->or_where($where3);
        $this->db->or_where($where4);
        $this->db->or_where($where5);
        $this->db->or_where($where6);
        $this->db->or_where($where7);*/

        $this->db->group_by('id');
        $this->db->limit(10);

        return $this->db->get($this->table)->result_array();
    }
}