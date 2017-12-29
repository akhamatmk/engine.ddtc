<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class P3b_article_model extends MY_Model {
    
    protected $table = 'p3b_article';
    protected $primary_key = 'p3b_article_id';
    
    function __construct()
    {
        parent::__construct();
    }

    function get_all_article($p3b_article_p3b)
    {
    	$this->db->where('p3b_article_p3b', $p3b_article_p3b);
    	$this->db->order_by('p3b_article_number', 'asc');

    	return $this->db->get($this->table)->result_array();
    }

    function get_article_range($p3b_article_p3b, $from, $to)
    {
    	$this->db->where('p3b_article_p3b', $p3b_article_p3b);
    	$this->db->where('p3b_article_number >=', $from);
    	$this->db->where('p3b_article_number <=', $to);
    	$this->db->order_by('p3b_article_number', 'asc');

    	return $this->db->get($this->table)->result_array();
    }

    function get_article_current($p3b_article_p3b, $cur)
    {
    	$this->db->where('p3b_article_p3b', $p3b_article_p3b);
    	$this->db->where('p3b_article_number', $cur);
    	$this->db->order_by('p3b_article_number', 'asc');

    	return $this->db->get($this->table)->result_array();
    }

    function get_terkait($terms)
    {
        $where1 = "p3b_article_content_id like '% $terms %'";
        $where2 = "p3b_article_content_en like '% $terms %'";

        $this->db->where($where1);
        $this->db->or_where($where2);
        $this->db->group_by('p3b_article_p3b');
        $this->db->limit(10);

        return $this->db->get($this->table)->result_array();
    }

    function delete_by_parent($p3b_article_p3b)
    {
        $this->db->where('p3b_article_p3b', $p3b_article_p3b);

        return $this->db->delete($this->table);   
    }
}