<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Voucher_global extends CI_Model{
  protected $db;
  protected $emp;
  protected $log;
  protected $admin;

  public $errors = array();

  public function __construct()
  {
    parent::__construct();
    $this->db = $this->load->database('admin',TRUE);
    $this->emp = $this->load->database('emp',TRUE);
    $this->log = $this->load->database('log',TRUE);
    $this->admin = $this->aauth->get_user();

    //Codeigniter : Write Less Do More
  }

  public function get_list($filter = FALSE, $select = "*")
  {
    $this->db->select($select);
    if($filter){
      $this->db->where($filter);
    }
    $stmt = $this->db->get('voucher');
    if($stmt->num_rows() == 0){
      return false;
    }
    return $stmt->result();
  }

  public function add_voucher($voucher = array(), $emp_id = FALSE)
  {
    if(!$emp_id){
      $this->errors = "no emp_id select";
      return false;
    }
    $insert_ids = array();
    $diff_ids = array();
    $update = array();


    $this->emp->where("vte_emp_id", $emp_id);
    if(!empty($voucher)){
      $this->emp->where_not_in("vte_voucher_id",$voucher);
    }
    $this->emp->delete('voucher_to_emp');
    $tmp = $this->emp
      ->select('vte_voucher_id')
      ->where('vte_emp_id',$emp_id)
      ->get('voucher_to_emp');
    foreach($tmp->result() as $val){
      $diff_ids[] = $val->vte_voucher_id;
    }

    $voucher = array_diff($voucher, $diff_ids);

    foreach($voucher as $val){
      $insert = array(
        "vte_voucher_id" => $val,
        "vte_emp_id" => $emp_id,
        "vte_add_date" => date("Y-m-d H:i:s"),
        "vte_add_admin_name" => $this->admin->name,
        "vte_add_admin_id" => $this->admin->id
      );
      $this->emp->insert("voucher_to_emp",$insert);
      $insert_ids[] = $this->emp->insert_id();

      $update[] = array(
        "vte_id" => $this->emp->insert_id(),
        "vte_token" => md5($this->emp->insert_id().date("Y-m-d H:i:s"))
      );
    }
    if(!empty($update)){
      $this->emp
  			->update_batch("voucher_to_emp",$update,"vte_id");
  		if($this->emp->affected_rows() <= 0){
        $this->errors = "xxxxxx";
  			return false;
  		}
    }
    return $insert_ids;
  }

  public function get_owner($emp_id, $filter=FALSE)
  {
    if(!$emp_id){
      $this->errors = "no emp_id select";
      return false;
    }
    $this->db
      ->from('pcg_employee.voucher_to_emp t1')
      ->join('pcg_admin.voucher t2','t2.voucher_id = t1.vte_voucher_id','inner')
      ->where('t1.vte_emp_id',$emp_id);
    if($filter){
      $this->db->where($filter);
    }
    $stmt = $this->db->get();
    //$stmt = $this->db->query("SELECT * FROM pcg_employee.voucher_to_emp t1 JOIN pcg_admin.voucher t2 ON t2.voucher_id = t1.vte_voucher_id WHERE t1.vte_emp_id = $emp_id");
    if($stmt->num_rows === 0){
      $this->errors = "no voucher for this employee";
      return false;
    }
    return $stmt->result();
  }

  public function get_list_cond($emp_id = FALSE,$mode = FALSE)
  {
    $for = array();
    $mode = (!$mode)?$_SESSION["voucher_mode"]:$mode;
    if($mode === "2"){
      $filter = array(
        "voucher_for" => "สมนาคุณ"
      );
      if(!$list_1 = $this->get_list($filter)){
        $list_1 = array();
      }
    }else{
      $for = array(
        "voucher_for" => "สวัสดิการ"
      );
      if(!$list_1 = $this->get_owner($emp_id,$for)){
        $list_1 = array();
      }
    }
    foreach($list_1 as $k=>$v){
      if(empty($v->voucher_quantity_bypass)){
        $this->log
          ->select('vl_id')
          ->where('vl_voucher_id',$v->voucher_id)
          ->where('vl_emp_id',$emp_id);
        switch($v->voucher_quantity_unit){
          case "วัน":
            $day_start = date('Y-m-d');
    				$day_end = date('Y-m-d 23:59:59');
            $this->log->where('vl_date >=', $day_start);
            $this->log->where('vl_date <=', $day_end);
          break;

          case "เดือน":
            $day_start = date('Y-m-01');
    				$day_end = date('Y-m-t 23:59:59');
            $this->log->where('vl_date >=', $day_start);
            $this->log->where('vl_date <=', $day_end);
          break;

          case "ปี":
            $day_start = date('Y-01-01');
    				$day_end = date('Y-12-t 23:59:59');
            $this->log->where('vl_date >=', $day_start);
            $this->log->where('vl_date <=', $day_end);
          break;

          default:
            unset($list_1[$key]);
          break;
        }
        $stmt = $this->log->get('voucher_log');
        $total = $stmt->num_rows();
        $list_1[$k]->remain = $v->voucher_quantity - $total;
      }else{
        $list_1[$k]->remain = 9999;
      }
    }
    return $list_1;
  }

  public function save_log($data)
  {
    $save = array();
    foreach($data["voucher_id"] as $val){
      $filter = array(
        "voucher_id" => $val
      );
      if($v_data = $this->get_list($filter)){
        $save[] = array(
          "vl_voucher_id" => $val,
          "vl_voucher_name" => $v_data[0]->voucher_name,
          "vl_emp_id" => $_SESSION["voucher_emp"],
          "vl_point" => $v_data[0]->voucher_price,
          "vl_date" => date("Y-m-d H:i:s"),
          "vl_add_admin_name" => $this->admin->name,
          "vl_add_admin_id" => $this->admin->id
        );
      }
    }
    $this->log->insert_batch("voucher_log",$save);
    $this->load->model('kpi/kpi_model','mkpi');
    return $this->mkpi->calc_point(1,$_SESSION["voucher_emp"],0);
  }

  public function voucher_diff($owner, $voucher)
  {
    $id1 = array();
    $id2 = array();
    foreach($owner as $val){
      $id1[] = $val->vte_voucher_id;
    }
    foreach($voucher as $val){
      $id2[] = $val->voucher_id;
    }
    $diff_ids = array_intersect($id2, $id1);

    foreach($voucher as $key=>$val){
      if((array_search($val->voucher_id, $diff_ids)) !== false) {
          unset($voucher[$key]);
      }
    }
    return $voucher;
  }

  public function empty_owner($emp_id)
  {
    if(!$emp_id){
      $this->errors = "no emp_id select";
      return false;
    }
    $this->emp->where("vte_emp_id", $emp_id);
    $this->emp->delete('voucher_to_emp');
    return true;
  }

  public function voucher_history($where)
  {
    $this->log
			->select_sum("A.vl_point","total_point");
		if($where){
			$this->log->where($where);
		}
		$sum_kpi = $this->log
			->get_compiled_select('voucher_log A');
		$this->log
				->from('voucher_log A')
				->join("($sum_kpi) B","B.total_point >= 0");
		if($where){
			$this->log->where($where);
		}
		$stmt = $this->log->get();
    // echo $this->log->last_query();
		$return = array(
			"num_rows" => $stmt->num_rows(),
			"data" => $stmt->result()
		);
		return $return;
  }

}
