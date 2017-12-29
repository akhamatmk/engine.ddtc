<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Feedback_model extends MY_Model {
    
    protected $table = 'feedback';
    protected $primary_key = 'feedback_id';
    protected $create_date = 'feedback_create';
    protected $update_date = 'feedback_update';
    
    function __construct()
    {
        parent::__construct();
    }
}