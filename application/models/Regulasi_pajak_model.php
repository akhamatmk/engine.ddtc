<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class regulasi_pajak_model extends MY_Model {
    
    protected $table = 'regulasi_pajak';
    protected $primary_key = 'id';
    protected $create_date = 'submit_date';
    
    function __construct()
    {
        parent::__construct();
    }

    function get_test_perpage($page, $perpage)
    {
        $start = ($page-1)*$perpage;
           
        $this->db->select('jenis_dokumen_lengkap, nomordokumen, id');
        $this->db->order_by('id', 'asc');
        $this->db->limit($perpage, $start);

        return $this->db->get($this->table)->result_array();
    }

    function get_top_view($limit = 10)
    {
        $this->db->where('publish', 1);
        $this->db->order_by('view', 'desc');
        $this->db->limit($limit);

        return $this->db->get($this->table)->result_array();
    }

    function get_top_download($limit = 10)
    {
        $this->db->where('publish', 1);
        $this->db->order_by('download', 'desc');
        $this->db->limit($limit);

        return $this->db->get($this->table)->result_array();
    }

    function get_field_publish($fields)
    {
        $this->db->select($fields);
        $this->db->where('publish', 1);
        
        return $this->db->get($this->table)->result_array();
    }
    
    function get_by($find, $key)
    {
        $this->db->where($find, $key);

        return $this->db->get($this->table)->row_array();
    }

    function get_publish_by($find, $key)
    {
        $this->db->where($find, $key);
        $this->db->where('publish', 1);

        return $this->db->get($this->table)->row_array();
    }

    function get_all_publish_perpage($page, $perpage)
    {
        $start = ($page-1)*$perpage;

        $this->db->where('publish', 1);
        //$this->db->where('publish', '1');
        $this->db->order_by('tanggal', 'desc');
        $this->db->limit($perpage, $start);

        return $this->db->get($this->table)->result_array();
    }
    
    function get_all_perpage($page, $perpage)
    {
        $start = ($page-1)*$perpage;
           
        $this->db->order_by('tanggal', 'desc');
        $this->db->limit($perpage, $start);

        return $this->db->get($this->table)->result_array();
    }
    
    function get_all_search_perpage($page, $perpage, $keyword)
    {
        $start = ($page-1)*$perpage;
           
        $this->db->or_like(array('jenis_dokumen_lengkap' => $keyword, 'nomordokumen'=> $keyword));
        $this->db->order_by('tanggal', 'asc');
        $this->db->limit($perpage, $start);

        return $this->db->get($this->table)->result_array();
    }

    function count_all_publish()
    {
        $this->db->where('publish', 1);
        //$this->db->where('publish', '1');
        $this->db->order_by('tanggal', 'desc');

        return $this->db->count_all_results($this->table);
    }
    
    function countall()
    {
        return $this->db->count_all_results($this->table);
    }

    function countallsearch($keyword)
    {
        $this->db->or_like(array('jenis_dokumen_lengkap' => $keyword, 'nomordokumen'=> $keyword));
        return $this->db->count_all_results($this->table);
    }

    function get_search_result($jenis_dokumen_lengkaps, $terms)
    {
        $i = 1;
        foreach($jenis_dokumen_lengkaps as $jenis_dokumen_lengkap)
        {
            if($i == 1) $this->db->where('jenis_dokumen_lengkap', $jenis_dokumen_lengkap);
            else $this->db->or_where('jenis_dokumen_lengkap', $jenis_dokumen_lengkap);

            $i++;
        }

        $where = "MATCH (body_final) AGAINST ('+$terms') > 0"; 

        $this->db->where($where);

        $this->db->order_by('tanggal', 'desc');
        $this->db->limit(10);

        return $this->db->get($this->table)->result_array();
    }

    function get_search_result_perpage($terms, $kategori, $jenis_dokumen_array, $tanggal, $tahun, $nomor, $method, $judul, $sort, $page, $perpage)
    {
        if($terms)
        {
            if (strpos($terms,'per ') !== false)
            {
                $short = "per";
                $long = "peraturan dirjen pajak";
            }

            if (strpos($terms,'se ') !== false)
            {
                $short = "se";
                $long = "surat edaran dirjen pajak";
            }

            if (strpos($terms,'kep ') !== false)
            {
                $short = "kep";
                $long = "keputusan dirjen pajak";
            }

            if (strpos($terms,'pmk ') !== false)
            {
                $short = "pmk";
                $long = "peraturan menteri keuangan";
            }

            if (strpos($terms,'kmk ') !== false)
            {
                $short = "kmk";
                $long = "keputusan menteri keuangan";
            }

            if (strpos($terms,'pp ') !== false)
            {
                $short = "pp";
                $long = "peraturan pemerintah";
            }

            if (strpos($terms,'uu ') !== false)
            {
                $short = "uu";
                $long = "undang-undang";
            }

            $terms = str_replace('per ', 'peraturan direktur jenderal pajak ', $terms);
            $terms = str_replace('se ', 'surat edaran direktur jenderal pajak ', $terms);
            $terms = str_replace('kep ', 'keputusan direktur jenderal pajak ', $terms);
            $terms = str_replace('pmk ', 'peraturan menteri keuangan ', $terms);
            $terms = str_replace('kmk ', 'keputusan menteri keuangan ', $terms);
            $terms = str_replace('pp ', 'peraturan pemerintah ', $terms);
            $terms = str_replace('uu ', 'undang-undang ', $terms);
        }
        else
        {
            $short = "";
            $long = "";
        }

        $start = ($page-1)*$perpage;

        if($sort == 'tahun') $sort = 'tanggal';
        if($sort == 'nomor') $sort = 'nomor';

        if($tanggal == '00-00-0000_00-00-0000') $tanggal = false;
        if($tahun == '0000') $tahun = false;
        if($nomor == '0_0') $nomor = false;
        if($terms == 'semua') $terms = false;

        if($kategori == 'semua-kategori' && $jenis_dokumen_array[0] == 'semua-dokumen')
        {
            if($terms)
            {
                $this->db->group_start();

                if(strlen($long) > 0)
                {
                    $where = "jenis_dokumen_lengkap like '%$long%'";
                }
                else
                {
                    $where = "MATCH(jenis_dokumen_lengkap) AGAINST ('+$terms' IN BOOLEAN MODE)";
                }

                $term = array_map('intval', explode(' ', $terms));

                foreach($term as $key => $value)
                {
                    if($value <= 0) 
                    {
                        unset($term[$key]);
                    }
                }

                if(count($term) > 0)
                {
                    $no = implode(',', $term);

                    $where .= " and nomor in ($no)";
                }

                //thn
                foreach($term as $key => $value)
                {
                    if(strlen($value) < 4)
                    {
                        unset($term[$key]);
                    }
                }

                if(count($term) > 0)
                {
                    $no = implode(',', $term);

                    $where .= " and tahun in ($no)";
                }
                //thn
                
                if($method == 'kalimat')
                {
                    if($judul == 0) $where .= " or body_final like '%$terms%'";
                    if($judul == 1) $where .= " or perihal like '%$terms%'";
                }
                if($method == 'atau')
                {
                    if($judul == 0) $where .= " or MATCH (body_final) AGAINST ('+$terms' IN BOOLEAN MODE)";
                    if($judul == 1) $where .= " or MATCH (perihal) AGAINST ('+$terms' IN BOOLEAN MODE)";
                }
                if($method == 'dan')
                {
                    /*
                    $terms_array = explode(" ", $terms);
                    $i_terms = count($terms_array);
                    $q_terms = "";
                    
                    for($i = 0 ; $i < $i_terms ; $i++) 
                    {
                        $q_terms .= " +" . $terms_array[$i];
                    }
                    */

                    $terms = trim($terms);
                    $terms = preg_replace('!\s+!', ' ', $terms);
                    $terms = str_replace(' ', ' +', $terms);
                    $q_terms = '+'.$terms;

                    if($judul == 0) $where .= " or MATCH (body_final) AGAINST ('$q_terms' IN BOOLEAN MODE)";
                    if($judul == 1) $where .= " or MATCH (perihal) AGAINST ('$q_terms' IN BOOLEAN MODE)";
                }

                $this->db->where($where);

                $this->db->group_end();
            }

            if($tanggal)
            {
                $tanggal_arr = explode("_", $tanggal);
                $tanggal_from = $tanggal_arr[0];
                $tanggal_to = $tanggal_arr[1];

                if($tanggal_from != '00-00-0000' && $tanggal_to == '00-00-0000')
                {
                    $tanggal_from = date("Y-m-d", strtotime($tanggal_from));
                    $this->db->where('tanggal', $tanggal_from);
                }
                if($tanggal_from != '00-00-0000' && $tanggal_to != '00-00-0000')
                {
                    $tanggal_from = date("Y-m-d", strtotime($tanggal_from));
                    $tanggal_to = date("Y-m-d", strtotime($tanggal_to));
                    $this->db->where('tanggal >=', $tanggal_from);
                    $this->db->where('tanggal <=', $tanggal_to);
                }
            }

            if($tahun) $this->db->where('tahun', $tahun);

            if($nomor)
            {
                $nomor_arr = explode("_", $nomor);
                $nomor_from = $nomor_arr[0];
                $nomor_to = $nomor_arr[1];

                if($nomor_from != '0' && $nomor_to == '0')
                {
                    $this->db->where('nomor', $nomor_from);
                }
                if($nomor_from != '0' && $nomor_to != '0')
                {
                    $this->db->where('nomor >=', $nomor_from);
                    $this->db->where('nomor <=', $nomor_to);
                }
                if($nomor_from == '0' && $nomor_to != '0')
                {
                    $this->db->where('nomor', $nomor_to);
                }
            }

            $this->db->where('publish', 1);
            //$this->db->where('publish', '1');
            $this->db->order_by($sort, 'desc');
            $this->db->limit($perpage, $start);

            return $this->db->get($this->table)->result_array();
        }

        if($kategori != 'semua-kategori' && $jenis_dokumen_array[0] == 'semua-dokumen')
        {
            if($terms)
            {
                $this->db->group_start();

                if(strlen($long) > 0)
                {
                    $where = "jenis_dokumen_lengkap like '%$long%'";
                }
                else
                {
                    $where = "MATCH(jenis_dokumen_lengkap) AGAINST ('+$terms' IN BOOLEAN MODE)";
                }

                $term = array_map('intval', explode(' ', $terms));

                foreach($term as $key => $value)
                {
                    if($value <= 0) 
                    {
                        unset($term[$key]);
                    }
                }

                if(count($term) > 0)
                {
                    $no = implode(',', $term);

                    $where .= " and nomor in ($no)";
                }

                //thn
                foreach($term as $key => $value)
                {
                    if(strlen($value) < 4)
                    {
                        unset($term[$key]);
                    }
                }

                if(count($term) > 0)
                {
                    $no = implode(',', $term);

                    $where .= " and tahun in ($no)";
                }
                //thn
                
                if($method == 'kalimat')
                {
                    if($judul == 0) $where .= " or body_final like '%$terms%'";
                    if($judul == 1) $where .= " or perihal like '%$terms%'";
                }
                if($method == 'atau')
                {
                    if($judul == 0) $where .= " or MATCH (body_final) AGAINST ('+$terms' IN BOOLEAN MODE)";
                    if($judul == 1) $where .= " or MATCH (perihal) AGAINST ('+$terms' IN BOOLEAN MODE)";
                }
                if($method == 'dan')
                {
                    /*
                    $terms_array = explode(" ", $terms);
                    $i_terms = count($terms_array);
                    $q_terms = "";
                    
                    for($i = 0 ; $i < $i_terms ; $i++) 
                    {
                        $q_terms .= " +" . $terms_array[$i];
                    }
                    */

                    $terms = trim($terms);
                    $terms = preg_replace('!\s+!', ' ', $terms);
                    $terms = str_replace(' ', ' +', $terms);
                    $q_terms = '+'.$terms;

                    if($judul == 0) $where .= " or MATCH (body_final) AGAINST ('$q_terms' IN BOOLEAN MODE)";
                    if($judul == 1) $where .= " or MATCH (perihal) AGAINST ('$q_terms' IN BOOLEAN MODE)";
                }

                $this->db->where($where);

                $this->db->group_end();
            }

            if(!empty($kategori)) { 
                if(is_array($kategori)) {
                    $this->db->group_start();
                    $i = 1;
                    foreach($kategori as $eachkategori) {
                        if($i == 1) {
                            $this->db->where('topik', $eachkategori);
                        } else {
                            $this->db->or_where('topik', $eachkategori);
                        }
                        $i++;
                    }
                    $this->db->group_end();
                } else {
                    $this->db->where('topik', $kategori);
                }
            }


            if($tanggal)
            {
                $tanggal_arr = explode("_", $tanggal);
                $tanggal_from = $tanggal_arr[0];
                $tanggal_to = $tanggal_arr[1];

                if($tanggal_from != '00-00-0000' && $tanggal_to == '00-00-0000')
                {
                    $tanggal_from = date("Y-m-d", strtotime($tanggal_from));
                    $this->db->where('tanggal', $tanggal_from);
                }
                if($tanggal_from != '00-00-0000' && $tanggal_to != '00-00-0000')
                {
                    $tanggal_from = date("Y-m-d", strtotime($tanggal_from));
                    $tanggal_to = date("Y-m-d", strtotime($tanggal_to));
                    $this->db->where('tanggal >=', $tanggal_from);
                    $this->db->where('tanggal <=', $tanggal_to);
                }
            }

            if($tahun) $this->db->where('tahun', $tahun);

            if($nomor)
            {
                $nomor_arr = explode("_", $nomor);
                $nomor_from = $nomor_arr[0];
                $nomor_to = $nomor_arr[1];

                if($nomor_from != '0' && $nomor_to == '0')
                {
                    $this->db->where('nomor', $nomor_from);
                }
                if($nomor_from != '0' && $nomor_to != '0')
                {
                    $this->db->where('nomor >=', $nomor_from);
                    $this->db->where('nomor <=', $nomor_to);
                }
                if($nomor_from == '0' && $nomor_to != '0')
                {
                    $this->db->where('nomor', $nomor_to);
                }
            }

            $this->db->where('publish', 1);
            //$this->db->where('publish', '1');
            $this->db->order_by($sort, 'desc');
            $this->db->limit($perpage, $start);

            return $this->db->get($this->table)->result_array();
        }

        if($kategori == 'semua-kategori' && $jenis_dokumen_array[0] != 'semua-dokumen')
        {
            $this->db->group_start();

            $i = 1;
            foreach($jenis_dokumen_array as $jenis_dokumen_lengkap)
            {
                $find = "Direktur Jenderal";
                $replace = "Dirjen";

                $jenis_dokumen_lengkap = str_replace($find, $replace, $jenis_dokumen_lengkap);

                if($i == 1) $this->db->where('jenis_dokumen_lengkap', $jenis_dokumen_lengkap);
                else $this->db->or_where('jenis_dokumen_lengkap', $jenis_dokumen_lengkap);

                $i++;
            }

            $this->db->group_end();

            if($terms)
            {
                $this->db->group_start();

                if(strlen($long) > 0)
                {
                    $where = "jenis_dokumen_lengkap like '%$long%'";
                }
                else
                {
                    $where = "MATCH(jenis_dokumen_lengkap) AGAINST ('+$terms' IN BOOLEAN MODE)";
                }

                $term = array_map('intval', explode(' ', $terms));

                foreach($term as $key => $value)
                {
                    if($value <= 0) 
                    {
                        unset($term[$key]);
                    }
                }

                if(count($term) > 0)
                {
                    $no = implode(',', $term);

                    $where .= " and nomor in ($no)";
                }

                //thn
                foreach($term as $key => $value)
                {
                    if(strlen($value) < 4)
                    {
                        unset($term[$key]);
                    }
                }

                if(count($term) > 0)
                {
                    $no = implode(',', $term);

                    $where .= " and tahun in ($no)";
                }
                //thn
                
                if($method == 'kalimat')
                {
                    if($judul == 0) $where .= " or body_final like '%$terms%'";
                    if($judul == 1) $where .= " or perihal like '%$terms%'";
                }
                if($method == 'atau')
                {
                    if($judul == 0) $where .= " or MATCH (body_final) AGAINST ('+$terms' IN BOOLEAN MODE)";
                    if($judul == 1) $where .= " or MATCH (perihal) AGAINST ('+$terms' IN BOOLEAN MODE)";
                }
                if($method == 'dan')
                {
                    /*
                    $terms_array = explode(" ", $terms);
                    $i_terms = count($terms_array);
                    $q_terms = "";
                    
                    for($i = 0 ; $i < $i_terms ; $i++) 
                    {
                        $q_terms .= " +" . $terms_array[$i];
                    }
                    */

                    $terms = trim($terms);
                    $terms = preg_replace('!\s+!', ' ', $terms);
                    $terms = str_replace(' ', ' +', $terms);
                    $q_terms = '+'.$terms;

                    if($judul == 0) $where .= " or MATCH (body_final) AGAINST ('$q_terms' IN BOOLEAN MODE)";
                    if($judul == 1) $where .= " or MATCH (perihal) AGAINST ('$q_terms' IN BOOLEAN MODE)";
                }

                $this->db->where($where);

                $this->db->group_end();
            }

            if($tanggal)
            {
                $tanggal_arr = explode("_", $tanggal);
                $tanggal_from = $tanggal_arr[0];
                $tanggal_to = $tanggal_arr[1];

                if($tanggal_from != '00-00-0000' && $tanggal_to == '00-00-0000')
                {
                    $tanggal_from = date("Y-m-d", strtotime($tanggal_from));
                    $this->db->where('tanggal', $tanggal_from);
                }
                if($tanggal_from != '00-00-0000' && $tanggal_to != '00-00-0000')
                {
                    $tanggal_from = date("Y-m-d", strtotime($tanggal_from));
                    $tanggal_to = date("Y-m-d", strtotime($tanggal_to));
                    $this->db->where('tanggal >=', $tanggal_from);
                    $this->db->where('tanggal <=', $tanggal_to);
                }
            }

            if($tahun) $this->db->where('tahun', $tahun);

            if($nomor)
            {
                $nomor_arr = explode("_", $nomor);
                $nomor_from = $nomor_arr[0];
                $nomor_to = $nomor_arr[1];

                if($nomor_from != '0' && $nomor_to == '0')
                {
                    $this->db->where('nomor', $nomor_from);
                }
                if($nomor_from != '0' && $nomor_to != '0')
                {
                    $this->db->where('nomor >=', $nomor_from);
                    $this->db->where('nomor <=', $nomor_to);
                }
                if($nomor_from == '0' && $nomor_to != '0')
                {
                    $this->db->where('nomor', $nomor_to);
                }
            }

            $this->db->where('publish', 1);
            //$this->db->where('publish', '1');
            $this->db->order_by($sort, 'desc');
            $this->db->limit($perpage, $start);

            return $this->db->get($this->table)->result_array();
        }

        if($kategori != 'semua-kategori' && $jenis_dokumen_array[0] != 'semua-dokumen')
        {
            $this->db->group_start();

            $i = 1;
            foreach($jenis_dokumen_array as $jenis_dokumen_lengkap)
            {
                $find = "Direktur Jenderal";
                $replace = "Dirjen";

                $jenis_dokumen_lengkap = str_replace($find, $replace, $jenis_dokumen_lengkap);

                if($i == 1) $this->db->where('jenis_dokumen_lengkap', $jenis_dokumen_lengkap);
                else $this->db->or_where('jenis_dokumen_lengkap', $jenis_dokumen_lengkap);

                $i++;
            }

            $this->db->group_end();

            if($terms)
            {
                $this->db->group_start();

                if(strlen($long) > 0)
                {
                    $where = "jenis_dokumen_lengkap like '%$long%'";
                }
                else
                {
                    $where = "MATCH(jenis_dokumen_lengkap) AGAINST ('+$terms' IN BOOLEAN MODE)";
                }

                $term = array_map('intval', explode(' ', $terms));

                foreach($term as $key => $value)
                {
                    if($value <= 0) 
                    {
                        unset($term[$key]);
                    }
                }

                if(count($term) > 0)
                {
                    $no = implode(',', $term);

                    $where .= " and nomor in ($no)";
                }

                //thn
                foreach($term as $key => $value)
                {
                    if(strlen($value) < 4)
                    {
                        unset($term[$key]);
                    }
                }

                if(count($term) > 0)
                {
                    $no = implode(',', $term);

                    $where .= " and tahun in ($no)";
                }
                //thn
                
                if($method == 'kalimat')
                {
                    if($judul == 0) $where .= " or body_final like '%$terms%'";
                    if($judul == 1) $where .= " or perihal like '%$terms%'";
                }
                if($method == 'atau')
                {
                    if($judul == 0) $where .= " or MATCH (body_final) AGAINST ('+$terms' IN BOOLEAN MODE)";
                    if($judul == 1) $where .= " or MATCH (perihal) AGAINST ('+$terms' IN BOOLEAN MODE)";
                }
                if($method == 'dan')
                {
                    /*
                    $terms_array = explode(" ", $terms);
                    $i_terms = count($terms_array);
                    $q_terms = "";
                    
                    for($i = 0 ; $i < $i_terms ; $i++) 
                    {
                        $q_terms .= " +" . $terms_array[$i];
                    }
                    */

                    $terms = trim($terms);
                    $terms = preg_replace('!\s+!', ' ', $terms);
                    $terms = str_replace(' ', ' +', $terms);
                    $q_terms = '+'.$terms;

                    if($judul == 0) $where .= " or MATCH (body_final) AGAINST ('$q_terms' IN BOOLEAN MODE)";
                    if($judul == 1) $where .= " or MATCH (perihal) AGAINST ('$q_terms' IN BOOLEAN MODE)";
                }

                $this->db->where($where);

                $this->db->group_end();
            }

            if(!empty($kategori)) { 
                if(is_array($kategori)) {
                    $this->db->group_start();
                    $i = 1;
                    foreach($kategori as $eachkategori) {
                        if($i == 1) {
                            $this->db->where('topik', $eachkategori);
                        } else {
                            $this->db->or_where('topik', $eachkategori);
                        }
                        $i++;
                    }
                    $this->db->group_end();
                } else {
                    $this->db->where('topik', $kategori);
                }
            }

            if($tanggal)
            {
                $tanggal_arr = explode("_", $tanggal);
                $tanggal_from = $tanggal_arr[0];
                $tanggal_to = $tanggal_arr[1];

                if($tanggal_from != '00-00-0000' && $tanggal_to == '00-00-0000')
                {
                    $tanggal_from = date("Y-m-d", strtotime($tanggal_from));
                    $this->db->where('tanggal', $tanggal_from);
                }
                if($tanggal_from != '00-00-0000' && $tanggal_to != '00-00-0000')
                {
                    $tanggal_from = date("Y-m-d", strtotime($tanggal_from));
                    $tanggal_to = date("Y-m-d", strtotime($tanggal_to));
                    $this->db->where('tanggal >=', $tanggal_from);
                    $this->db->where('tanggal <=', $tanggal_to);
                }
            }

            if($tahun) $this->db->where('tahun', $tahun);

            if($nomor)
            {
                $nomor_arr = explode("_", $nomor);
                $nomor_from = $nomor_arr[0];
                $nomor_to = $nomor_arr[1];

                if($nomor_from != '0' && $nomor_to == '0')
                {
                    $this->db->where('nomor', $nomor_from);
                }
                if($nomor_from != '0' && $nomor_to != '0')
                {
                    $this->db->where('nomor >=', $nomor_from);
                    $this->db->where('nomor <=', $nomor_to);
                }
                if($nomor_from == '0' && $nomor_to != '0')
                {
                    $this->db->where('nomor', $nomor_to);
                }
            }

            $this->db->where('publish', 1);
            //$this->db->where('publish', '1');
            $this->db->order_by($sort, 'desc');
            $this->db->limit($perpage, $start);

            return $this->db->get($this->table)->result_array();
        }
    }

    function get_search_result_all($terms, $kategori, $jenis_dokumen_array, $tanggal, $tahun, $nomor, $method, $judul, $sort)
    {
        if($terms)
        {
            if (strpos($terms,'per ') !== false)
            {
                $short = "per";
                $long = "peraturan dirjen pajak";
            }

            if (strpos($terms,'se ') !== false)
            {
                $short = "se";
                $long = "surat edaran dirjen pajak";
            }

            if (strpos($terms,'kep ') !== false)
            {
                $short = "kep";
                $long = "keputusan dirjen pajak";
            }

            if (strpos($terms,'pmk ') !== false)
            {
                $short = "pmk";
                $long = "peraturan menteri keuangan";
            }

            if (strpos($terms,'kmk ') !== false)
            {
                $short = "kmk";
                $long = "keputusan menteri keuangan";
            }

            if (strpos($terms,'pp ') !== false)
            {
                $short = "pp";
                $long = "peraturan pemerintah";
            }

            if (strpos($terms,'uu ') !== false)
            {
                $short = "uu";
                $long = "undang-undang";
            }

            $terms = str_replace('per ', 'peraturan direktur jenderal pajak ', $terms);
            $terms = str_replace('se ', 'surat edaran direktur jenderal pajak ', $terms);
            $terms = str_replace('kep ', 'keputusan direktur jenderal pajak ', $terms);
            $terms = str_replace('pmk ', 'peraturan menteri keuangan ', $terms);
            $terms = str_replace('kmk ', 'keputusan menteri keuangan ', $terms);
            $terms = str_replace('pp ', 'peraturan pemerintah ', $terms);
            $terms = str_replace('uu ', 'undang-undang ', $terms);
        }
        else
        {
            $short = "";
            $long = "";
        }
        
        $this->db->select('id');

        if($sort == 'tahun') $sort = 'tanggal';
        if($sort == 'nomor') $sort = 'nomor';
        
        if($tanggal == '00-00-0000_00-00-0000') $tanggal = false;
        if($tahun == '0000') $tahun = false;
        if($nomor == '0_0') $nomor = false;
        if($terms == 'semua') $terms = false;

        if($kategori == 'semua-kategori' && $jenis_dokumen_array[0] == 'semua-dokumen')
        {
            if($terms)
            {
                $this->db->group_start();

                if(strlen($long) > 0)
                {
                    $where = "jenis_dokumen_lengkap like '%$long%'";
                }
                else
                {
                    $where = "MATCH(jenis_dokumen_lengkap) AGAINST ('+$terms' IN BOOLEAN MODE)";
                }

                $term = array_map('intval', explode(' ', $terms));

                foreach($term as $key => $value)
                {
                    if($value <= 0) 
                    {
                        unset($term[$key]);
                    }
                }

                if(count($term) > 0)
                {
                    $no = implode(',', $term);

                    $where .= " and nomor in ($no)";
                }

                //thn
                foreach($term as $key => $value)
                {
                    if(strlen($value) < 4)
                    {
                        unset($term[$key]);
                    }
                }

                if(count($term) > 0)
                {
                    $no = implode(',', $term);

                    $where .= " and tahun in ($no)";
                }
                //thn
                
                if($method == 'kalimat')
                {
                    if($judul == 0) $where .= " or body_final like '%$terms%'";
                    if($judul == 1) $where .= " or perihal like '%$terms%'";
                }
                if($method == 'atau')
                {
                    if($judul == 0) $where .= " or MATCH (body_final) AGAINST ('+$terms' IN BOOLEAN MODE)";
                    if($judul == 1) $where .= " or MATCH (perihal) AGAINST ('+$terms' IN BOOLEAN MODE)";
                }
                if($method == 'dan')
                {
                    /*
                    $terms_array = explode(" ", $terms);
                    $i_terms = count($terms_array);
                    $q_terms = "";
                    
                    for($i = 0 ; $i < $i_terms ; $i++) 
                    {
                        $q_terms .= " +" . $terms_array[$i];
                    }
                    */

                    $terms = trim($terms);
                    $terms = preg_replace('!\s+!', ' ', $terms);
                    $terms = str_replace(' ', ' +', $terms);
                    $q_terms = '+'.$terms;

                    if($judul == 0) $where .= " or MATCH (body_final) AGAINST ('$q_terms' IN BOOLEAN MODE)";
                    if($judul == 1) $where .= " or MATCH (perihal) AGAINST ('$q_terms' IN BOOLEAN MODE)";
                }

                $this->db->where($where);

                $this->db->group_end();
            }

            if($tanggal)
            {
                $tanggal_arr = explode("_", $tanggal);
                $tanggal_from = $tanggal_arr[0];
                $tanggal_to = $tanggal_arr[1];

                if($tanggal_from != '00-00-0000' && $tanggal_to == '00-00-0000')
                {
                    $tanggal_from = date("Y-m-d", strtotime($tanggal_from));
                    $this->db->where('tanggal', $tanggal_from);
                }
                if($tanggal_from != '00-00-0000' && $tanggal_to != '00-00-0000')
                {
                    $tanggal_from = date("Y-m-d", strtotime($tanggal_from));
                    $tanggal_to = date("Y-m-d", strtotime($tanggal_to));
                    $this->db->where('tanggal >=', $tanggal_from);
                    $this->db->where('tanggal <=', $tanggal_to);
                }
            }

            if($tahun) $this->db->where('tahun', $tahun);

            if($nomor)
            {
                $nomor_arr = explode("_", $nomor);
                $nomor_from = $nomor_arr[0];
                $nomor_to = $nomor_arr[1];

                if($nomor_from != '0' && $nomor_to == '0')
                {
                    $this->db->where('nomor', $nomor_from);
                }
                if($nomor_from != '0' && $nomor_to != '0')
                {
                    $this->db->where('nomor >=', $nomor_from);
                    $this->db->where('nomor <=', $nomor_to);
                }
                if($nomor_from == '0' && $nomor_to != '0')
                {
                    $this->db->where('nomor', $nomor_to);
                }
            }

            $this->db->where('publish', 1);
            //$this->db->where('publish', '1');
            $this->db->order_by($sort, 'desc');

            return $this->db->get($this->table)->result_array();
        }

        if($kategori != 'semua-kategori' && $jenis_dokumen_array[0] == 'semua-dokumen')
        {
            if($terms)
            {
                $this->db->group_start();

                if(strlen($long) > 0)
                {
                    $where = "jenis_dokumen_lengkap like '%$long%'";
                }
                else
                {
                    $where = "MATCH(jenis_dokumen_lengkap) AGAINST ('+$terms' IN BOOLEAN MODE)";
                }

                $term = array_map('intval', explode(' ', $terms));

                foreach($term as $key => $value)
                {
                    if($value <= 0) 
                    {
                        unset($term[$key]);
                    }
                }

                if(count($term) > 0)
                {
                    $no = implode(',', $term);

                    $where .= " and nomor in ($no)";
                }

                //thn
                foreach($term as $key => $value)
                {
                    if(strlen($value) < 4)
                    {
                        unset($term[$key]);
                    }
                }

                if(count($term) > 0)
                {
                    $no = implode(',', $term);

                    $where .= " and tahun in ($no)";
                }
                //thn
                
                if($method == 'kalimat')
                {
                    if($judul == 0) $where .= " or body_final like '%$terms%'";
                    if($judul == 1) $where .= " or perihal like '%$terms%'";
                }
                if($method == 'atau')
                {
                    if($judul == 0) $where .= " or MATCH (body_final) AGAINST ('+$terms' IN BOOLEAN MODE)";
                    if($judul == 1) $where .= " or MATCH (perihal) AGAINST ('+$terms' IN BOOLEAN MODE)";
                }
                if($method == 'dan')
                {
                    /*
                    $terms_array = explode(" ", $terms);
                    $i_terms = count($terms_array);
                    $q_terms = "";
                    
                    for($i = 0 ; $i < $i_terms ; $i++) 
                    {
                        $q_terms .= " +" . $terms_array[$i];
                    }
                    */

                    $terms = trim($terms);
                    $terms = preg_replace('!\s+!', ' ', $terms);
                    $terms = str_replace(' ', ' +', $terms);
                    $q_terms = '+'.$terms;

                    if($judul == 0) $where .= " or MATCH (body_final) AGAINST ('$q_terms' IN BOOLEAN MODE)";
                    if($judul == 1) $where .= " or MATCH (perihal) AGAINST ('$q_terms' IN BOOLEAN MODE)";
                }

                $this->db->where($where);

                $this->db->group_end();
            }

            if(!empty($kategori)) { 
                if(is_array($kategori)) {
                    $this->db->group_start();
                    $i = 1;
                    foreach($kategori as $eachkategori) {
                        if($i == 1) {
                            $this->db->where('topik', $eachkategori);
                        } else {
                            $this->db->or_where('topik', $eachkategori);
                        }
                        $i++;
                    }
                    $this->db->group_end();
                } else {
                    $this->db->where('topik', $kategori);
                }
            }

            if($tanggal)
            {
                $tanggal_arr = explode("_", $tanggal);
                $tanggal_from = $tanggal_arr[0];
                $tanggal_to = $tanggal_arr[1];

                if($tanggal_from != '00-00-0000' && $tanggal_to == '00-00-0000')
                {
                    $tanggal_from = date("Y-m-d", strtotime($tanggal_from));
                    $this->db->where('tanggal', $tanggal_from);
                }
                if($tanggal_from != '00-00-0000' && $tanggal_to != '00-00-0000')
                {
                    $tanggal_from = date("Y-m-d", strtotime($tanggal_from));
                    $tanggal_to = date("Y-m-d", strtotime($tanggal_to));
                    $this->db->where('tanggal >=', $tanggal_from);
                    $this->db->where('tanggal <=', $tanggal_to);
                }
            }

            if($tahun) $this->db->where('tahun', $tahun);

            if($nomor)
            {
                $nomor_arr = explode("_", $nomor);
                $nomor_from = $nomor_arr[0];
                $nomor_to = $nomor_arr[1];

                if($nomor_from != '0' && $nomor_to == '0')
                {
                    $this->db->where('nomor', $nomor_from);
                }
                if($nomor_from != '0' && $nomor_to != '0')
                {
                    $this->db->where('nomor >=', $nomor_from);
                    $this->db->where('nomor <=', $nomor_to);
                }
                if($nomor_from == '0' && $nomor_to != '0')
                {
                    $this->db->where('nomor', $nomor_to);
                }
            }

            $this->db->where('publish', 1);
            //$this->db->where('publish', '1');
            $this->db->order_by($sort, 'desc');

            return $this->db->get($this->table)->result_array();
        }

        if($kategori == 'semua-kategori' && $jenis_dokumen_array[0] != 'semua-dokumen')
        {
            $this->db->group_start();

            $i = 1;
            foreach($jenis_dokumen_array as $jenis_dokumen_lengkap)
            {
                $find = "Direktur Jenderal";
                $replace = "Dirjen";

                $jenis_dokumen_lengkap = str_replace($find, $replace, $jenis_dokumen_lengkap);

                if($i == 1) $this->db->where('jenis_dokumen_lengkap', $jenis_dokumen_lengkap);
                else $this->db->or_where('jenis_dokumen_lengkap', $jenis_dokumen_lengkap);

                $i++;
            }

            $this->db->group_end();

            if($terms)
            {
                $this->db->group_start();

                if(strlen($long) > 0)
                {
                    $where = "jenis_dokumen_lengkap like '%$long%'";
                }
                else
                {
                    $where = "MATCH(jenis_dokumen_lengkap) AGAINST ('+$terms' IN BOOLEAN MODE)";
                }

                $term = array_map('intval', explode(' ', $terms));

                foreach($term as $key => $value)
                {
                    if($value <= 0) 
                    {
                        unset($term[$key]);
                    }
                }

                if(count($term) > 0)
                {
                    $no = implode(',', $term);

                    $where .= " and nomor in ($no)";
                }

                //thn
                foreach($term as $key => $value)
                {
                    if(strlen($value) < 4)
                    {
                        unset($term[$key]);
                    }
                }

                if(count($term) > 0)
                {
                    $no = implode(',', $term);

                    $where .= " and tahun in ($no)";
                }
                //thn
                
                if($method == 'kalimat')
                {
                    if($judul == 0) $where .= " or body_final like '%$terms%'";
                    if($judul == 1) $where .= " or perihal like '%$terms%'";
                }
                if($method == 'atau')
                {
                    if($judul == 0) $where .= " or MATCH (body_final) AGAINST ('+$terms' IN BOOLEAN MODE)";
                    if($judul == 1) $where .= " or MATCH (perihal) AGAINST ('+$terms' IN BOOLEAN MODE)";
                }
                if($method == 'dan')
                {
                    /*
                    $terms_array = explode(" ", $terms);
                    $i_terms = count($terms_array);
                    $q_terms = "";
                    
                    for($i = 0 ; $i < $i_terms ; $i++) 
                    {
                        $q_terms .= " +" . $terms_array[$i];
                    }
                    */

                    $terms = trim($terms);
                    $terms = preg_replace('!\s+!', ' ', $terms);
                    $terms = str_replace(' ', ' +', $terms);
                    $q_terms = '+'.$terms;

                    if($judul == 0) $where .= " or MATCH (body_final) AGAINST ('$q_terms' IN BOOLEAN MODE)";
                    if($judul == 1) $where .= " or MATCH (perihal) AGAINST ('$q_terms' IN BOOLEAN MODE)";
                }

                $this->db->where($where);

                $this->db->group_end();
            }

            if($tanggal)
            {
                $tanggal_arr = explode("_", $tanggal);
                $tanggal_from = $tanggal_arr[0];
                $tanggal_to = $tanggal_arr[1];

                if($tanggal_from != '00-00-0000' && $tanggal_to == '00-00-0000')
                {
                    $tanggal_from = date("Y-m-d", strtotime($tanggal_from));
                    $this->db->where('tanggal', $tanggal_from);
                }
                if($tanggal_from != '00-00-0000' && $tanggal_to != '00-00-0000')
                {
                    $tanggal_from = date("Y-m-d", strtotime($tanggal_from));
                    $tanggal_to = date("Y-m-d", strtotime($tanggal_to));
                    $this->db->where('tanggal >=', $tanggal_from);
                    $this->db->where('tanggal <=', $tanggal_to);
                }
            }

            if($tahun) $this->db->where('tahun', $tahun);

            if($nomor)
            {
                $nomor_arr = explode("_", $nomor);
                $nomor_from = $nomor_arr[0];
                $nomor_to = $nomor_arr[1];

                if($nomor_from != '0' && $nomor_to == '0')
                {
                    $this->db->where('nomor', $nomor_from);
                }
                if($nomor_from != '0' && $nomor_to != '0')
                {
                    $this->db->where('nomor >=', $nomor_from);
                    $this->db->where('nomor <=', $nomor_to);
                }
                if($nomor_from == '0' && $nomor_to != '0')
                {
                    $this->db->where('nomor', $nomor_to);
                }
            }

            $this->db->where('publish', 1);
            //$this->db->where('publish', '1');
            $this->db->order_by($sort, 'desc');

            return $this->db->get($this->table)->result_array();
        }

        if($kategori != 'semua-kategori' && $jenis_dokumen_array[0] != 'semua-dokumen')
        {
            $this->db->group_start();

            $i = 1;
            foreach($jenis_dokumen_array as $jenis_dokumen_lengkap)
            {
                $find = "Direktur Jenderal";
                $replace = "Dirjen";

                $jenis_dokumen_lengkap = str_replace($find, $replace, $jenis_dokumen_lengkap);

                if($i == 1) $this->db->where('jenis_dokumen_lengkap', $jenis_dokumen_lengkap);
                else $this->db->or_where('jenis_dokumen_lengkap', $jenis_dokumen_lengkap);

                $i++;
            }

            $this->db->group_end();

            if($terms)
            {
                $this->db->group_start();

                if(strlen($long) > 0)
                {
                    $where = "jenis_dokumen_lengkap like '%$long%'";
                }
                else
                {
                    $where = "MATCH(jenis_dokumen_lengkap) AGAINST ('+$terms' IN BOOLEAN MODE)";
                }

                $term = array_map('intval', explode(' ', $terms));

                foreach($term as $key => $value)
                {
                    if($value <= 0) 
                    {
                        unset($term[$key]);
                    }
                }

                if(count($term) > 0)
                {
                    $no = implode(',', $term);

                    $where .= " and nomor in ($no)";
                }

                //thn
                foreach($term as $key => $value)
                {
                    if(strlen($value) < 4)
                    {
                        unset($term[$key]);
                    }
                }

                if(count($term) > 0)
                {
                    $no = implode(',', $term);

                    $where .= " and tahun in ($no)";
                }
                //thn
                
                if($method == 'kalimat')
                {
                    if($judul == 0) $where .= " or body_final like '%$terms%'";
                    if($judul == 1) $where .= " or perihal like '%$terms%'";
                }
                if($method == 'atau')
                {
                    if($judul == 0) $where .= " or MATCH (body_final) AGAINST ('+$terms' IN BOOLEAN MODE)";
                    if($judul == 1) $where .= " or MATCH (perihal) AGAINST ('+$terms' IN BOOLEAN MODE)";
                }
                if($method == 'dan')
                {
                    /*
                    $terms_array = explode(" ", $terms);
                    $i_terms = count($terms_array);
                    $q_terms = "";
                    
                    for($i = 0 ; $i < $i_terms ; $i++) 
                    {
                        $q_terms .= " +" . $terms_array[$i];
                    }
                    */

                    $terms = trim($terms);
                    $terms = preg_replace('!\s+!', ' ', $terms);
                    $terms = str_replace(' ', ' +', $terms);
                    $q_terms = '+'.$terms;

                    if($judul == 0) $where .= " or MATCH (body_final) AGAINST ('$q_terms' IN BOOLEAN MODE)";
                    if($judul == 1) $where .= " or MATCH (perihal) AGAINST ('$q_terms' IN BOOLEAN MODE)";
                }

                $this->db->where($where);

                $this->db->group_end();
            }

            if(!empty($kategori)) { 
                if(is_array($kategori)) {
                    $this->db->group_start();
                    $i = 1;
                    foreach($kategori as $eachkategori) {
                        if($i == 1) {
                            $this->db->where('topik', $eachkategori);
                        } else {
                            $this->db->or_where('topik', $eachkategori);
                        }
                        $i++;
                    }
                    $this->db->group_end();
                } else {
                    $this->db->where('topik', $kategori);
                }
            }

            if($tanggal)
            {
                $tanggal_arr = explode("_", $tanggal);
                $tanggal_from = $tanggal_arr[0];
                $tanggal_to = $tanggal_arr[1];

                if($tanggal_from != '00-00-0000' && $tanggal_to == '00-00-0000')
                {
                    $tanggal_from = date("Y-m-d", strtotime($tanggal_from));
                    $this->db->where('tanggal', $tanggal_from);
                }
                if($tanggal_from != '00-00-0000' && $tanggal_to != '00-00-0000')
                {
                    $tanggal_from = date("Y-m-d", strtotime($tanggal_from));
                    $tanggal_to = date("Y-m-d", strtotime($tanggal_to));
                    $this->db->where('tanggal >=', $tanggal_from);
                    $this->db->where('tanggal <=', $tanggal_to);
                }
            }

            if($tahun) $this->db->where('tahun', $tahun);

            if($nomor)
            {
                $nomor_arr = explode("_", $nomor);
                $nomor_from = $nomor_arr[0];
                $nomor_to = $nomor_arr[1];

                if($nomor_from != '0' && $nomor_to == '0')
                {
                    $this->db->where('nomor', $nomor_from);
                }
                if($nomor_from != '0' && $nomor_to != '0')
                {
                    $this->db->where('nomor >=', $nomor_from);
                    $this->db->where('nomor <=', $nomor_to);
                }
                if($nomor_from == '0' && $nomor_to != '0')
                {
                    $this->db->where('nomor', $nomor_to);
                }
            }

            $this->db->where('publish', 1);
            //$this->db->where('publish', '1');
            $this->db->order_by($sort, 'desc');

            return $this->db->get($this->table)->result_array();
        }
    }

    function get_latest_document($limit = 2)
    {
        $this->db->order_by('tanggal', 'desc');
        $this->db->limit($limit);

        return $this->db->get($this->table)->result_array();
    }

    function get_notif_new_document()
    {
        $this->db->order_by('tanggal', 'desc');
        $this->db->limit(1);

        $result = $this->db->get($this->table)->row_array();

        $tanggal = $result['tanggal'];

        $this->db->where('tanggal', $tanggal);
        return $this->db->get($this->table)->result_array();
    }

    function get_all_year()
    {
        $this->db->select('tahun');
        $this->db->order_by('tahun', 'desc');
        $this->db->group_by('tahun');
        return $this->db->get($this->table)->result_array();
    }

    function get_latest_per()
    {
        $this->db->select('submit_date');
        $this->db->where('publish', 1);
        $this->db->order_by('submit_date', 'desc');
        $this->db->limit(1);

        return $this->db->get($this->table)->row_array();
    }
}