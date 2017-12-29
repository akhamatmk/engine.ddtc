<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends MY_Model {
    
    protected $table = 'user';
    protected $primary_key = 'user_id';
    protected $create_date = 'user_create';
    protected $update_date = 'user_update';
    
    function __construct()
    {
        parent::__construct();
    }

    function get_by($find, $key)
    {
        $this->db->where($find, $key);

        return $this->db->get($this->table)->row_array();
    }

    function check_user($find, $key)
    {
        $this->db->where($find, $key);

        return $this->db->count_all_results($this->table);
    }

    function update_login_last($user_id)
    {
        $this->db->where($this->primary_key, $user_id);
        $user = $this->db->get($this->table)->row_array();

        $user_login_current = $user['user_login_current'];

        $this->db->set('user_login_last', $user_login_current);
        $this->db->where($this->primary_key, $user_id);

        return $this->db->update($this->table);
    }

    function update_login_current($user_id)
    {
        $this->db->set('user_login_current', 'NOW()', false);
        $this->db->where($this->primary_key, $user_id);

        return $this->db->update($this->table);
    }
}