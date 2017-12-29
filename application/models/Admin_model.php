<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model extends MY_Model {
    
    protected $table = 'admin';
    protected $primary_key = 'admin_id';
    protected $create_date = 'admin_create';
    protected $update_date = 'admin_update';
    
    function __construct()
    {
        parent::__construct();
    }
}