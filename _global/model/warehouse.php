<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Warehouse_global extends CI_Model{
  protected $db;
  protected $emp;
  protected $log;
  protected $admin;

  public $errors = array();

  public function __construct()
  {
    $this->admin = $this->load->database('admin',false);
    $this->log = $this->load->database('log',false);
  }

  public function get_wh_bench()
  {
    $stmt = $this->admin->get('warehouse');
    if($stmt->num_rows() > 0){
      
    }
  }
}
