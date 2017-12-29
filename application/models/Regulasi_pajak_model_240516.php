<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class regulasi_pajak_model extends MY_Model {
    
    protected $table = 'regulasi_pajak';
    protected $primary_key = 'id';
    protected $create_date = 'submit_date';
    
    function __construct()
    {
        parent::__construct();
    }

    function get_all_publish_perpage($page, $perpage)
    {
        $start = ($page-1)*$perpage;

        $this->db->where('publish', 1);
        $this->db->order_by('tanggal', 'desc');
        $this->db->limit($perpage, $start);

        return $this->db->get($this->table)->result_array();
    }

    function count_all_publish()
    {
        $this->db->where('publish', 1);
        $this->db->order_by('tanggal', 'desc');

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
                $where = "MATCH(jenis_dokumen_lengkap) AGAINST ('+$terms' IN BOOLEAN MODE)";

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

                $this->db->where($where);
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
            $this->db->order_by($sort, 'desc');
            $this->db->limit($perpage, $start);

            return $this->db->get($this->table)->result_array();
        }

        if($kategori != 'semua-kategori' && $jenis_dokumen_array[0] == 'semua-dokumen')
        {
            if($terms)
            {
                $where = "MATCH(jenis_dokumen_lengkap) AGAINST ('+$terms' IN BOOLEAN MODE)";

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

                $this->db->where($where);
            }

            $this->db->where('topik', $kategori);

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
            $this->db->order_by($sort, 'desc');
            $this->db->limit($perpage, $start);

            return $this->db->get($this->table)->result_array();
        }

        if($kategori == 'semua-kategori' && $jenis_dokumen_array[0] != 'semua-dokumen')
        {
            $i = 1;
            foreach($jenis_dokumen_array as $jenis_dokumen_lengkap)
            {
                if($i == 1) $this->db->where('jenis_dokumen_lengkap', $jenis_dokumen_lengkap);
                else $this->db->or_where('jenis_dokumen_lengkap', $jenis_dokumen_lengkap);

                $i++;
            }

            if($terms)
            {
                $where = "MATCH(jenis_dokumen_lengkap) AGAINST ('+$terms' IN BOOLEAN MODE)";

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

                $this->db->where($where);
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
            $this->db->order_by($sort, 'desc');
            $this->db->limit($perpage, $start);

            return $this->db->get($this->table)->result_array();
        }

        if($kategori != 'semua-kategori' && $jenis_dokumen_array[0] != 'semua-dokumen')
        {
            $i = 1;
            foreach($jenis_dokumen_array as $jenis_dokumen_lengkap)
            {
                if($i == 1) $this->db->where('jenis_dokumen_lengkap', $jenis_dokumen_lengkap);
                else $this->db->or_where('jenis_dokumen_lengkap', $jenis_dokumen_lengkap);

                $i++;
            }

            if($terms)
            {
                $where = "MATCH(jenis_dokumen_lengkap) AGAINST ('+$terms' IN BOOLEAN MODE)";

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

                $this->db->where($where);
            }

            $this->db->where('topik', $kategori);

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
            $this->db->order_by($sort, 'desc');
            $this->db->limit($perpage, $start);

            return $this->db->get($this->table)->result_array();
        }
    }

    function get_search_result_all($terms, $kategori, $jenis_dokumen_array, $tanggal, $tahun, $nomor, $method, $judul, $sort)
    {
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
                $where = "MATCH(jenis_dokumen_lengkap) AGAINST ('+$terms' IN BOOLEAN MODE)";

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

                $this->db->where($where);
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
            $this->db->order_by($sort, 'desc');

            return $this->db->get($this->table)->result_array();
        }

        if($kategori != 'semua-kategori' && $jenis_dokumen_array[0] == 'semua-dokumen')
        {
            if($terms)
            {
                $where = "MATCH(jenis_dokumen_lengkap) AGAINST ('+$terms' IN BOOLEAN MODE)";

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

                $this->db->where($where);
            }

            $this->db->where('topik', $kategori);

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
            $this->db->order_by($sort, 'desc');

            return $this->db->get($this->table)->result_array();
        }

        if($kategori == 'semua-kategori' && $jenis_dokumen_array[0] != 'semua-dokumen')
        {
            $i = 1;
            foreach($jenis_dokumen_array as $jenis_dokumen_lengkap)
            {
                if($i == 1) $this->db->where('jenis_dokumen_lengkap', $jenis_dokumen_lengkap);
                else $this->db->or_where('jenis_dokumen_lengkap', $jenis_dokumen_lengkap);

                $i++;
            }

            if($terms)
            {
                $where = "MATCH(jenis_dokumen_lengkap) AGAINST ('+$terms' IN BOOLEAN MODE)";

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

                $this->db->where($where);
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
            $this->db->order_by($sort, 'desc');

            return $this->db->get($this->table)->result_array();
        }

        if($kategori != 'semua-kategori' && $jenis_dokumen_array[0] != 'semua-dokumen')
        {
            $i = 1;
            foreach($jenis_dokumen_array as $jenis_dokumen_lengkap)
            {
                if($i == 1) $this->db->where('jenis_dokumen_lengkap', $jenis_dokumen_lengkap);
                else $this->db->or_where('jenis_dokumen_lengkap', $jenis_dokumen_lengkap);

                $i++;
            }

            if($terms)
            {
                $where = "MATCH(jenis_dokumen_lengkap) AGAINST ('+$terms' IN BOOLEAN MODE)";

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

                $this->db->where($where);
            }

            $this->db->where('topik', $kategori);

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
}