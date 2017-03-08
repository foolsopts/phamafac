<?php
class Global_model extends CI_Model {
	public $db;
	public $upload_target;
	public $ci;
	public $errors = array();
	public $flash_errors = array();

	public function __construct() {
		parent::__construct();
		$this->ci =& get_instance();
	}
	public function get_list($param = array())
	{
		$default = array(
      "database" => "admin",
			"table" => "",
			"select" => "*",
			"select2" => FALSE,
			"where" => FALSE,
			"where_in" => FALSE,
			"where_not_in" => FALSE,
			"group_by" => FALSE,
			"order" => FALSE,
			"sort" => "DESC",
			"limit" => FALSE,
			"from" => NULL
		);
		$var = getter_param($default,$param);
		$this->db = $this->load->database($var->database,TRUE);
		$this->db->trans_begin();

		if($var->select !== FALSE){
			$this->db->select($var->select);
		}
		if($var->select2 !== FALSE){
			$this->db->select($var->select2);
		}
		$this->db->from($var->table);
		if($var->order){
			$this->db->order_by($var->order,$var->sort);
		}
		if($var->where){
			$this->db->where($var->where);
		}
		if($var->where_in){
			$this->db->where_in($var->where_in[0],$var->where_in[1]);
		}
		if($var->where_not_in){
			$this->db->where_not_in($var->where_not_in[0],$var->where_not_in[1]);
		}
		if($var->group_by){
			$this->db->group_by($var->group_by);
		}
		if($var->limit){
			if($var->from === NULL){
				$this->db->limit($var->limit);
			}else{
				$this->db->limit($var->limit,$var->from);
			}
		}
		$stmt = $this->db->get();

		if($this->db->trans_status() === FALSE){
			$this->db->trans_commit();
			$this->error($this->db->error());
			return false;
		}
		if($stmt->num_rows() <= 0){
			$this->db->trans_commit();
			$this->error($this->db->last_query());
			return false;
		}
		$return = array(
			"num_rows" => $stmt->num_rows(),
			"data" => $stmt->result()
		);
		return $return;
	}

	public function error($message = '', $flashdata = TRUE){
		$this->errors[] = $message;
		if($flashdata)
		{
			$this->flash_errors[] = $message;
			$this->ci->session->set_flashdata('errors', $this->flash_errors);
		}
	}

	public function save_log($arr)
	{

		$admin = $this->aauth->get_user();
		$log = array();
		$this->db = $this->load->database('log',TRUE);
		if(!empty($arr[0])){
			foreach($arr as $key=>$val){
				$log[$key]["log_action_type"] = $val["log_type"];
				$log[$key]["log_action_to"] = $val["to"];
				$log[$key]["log_action_to_name"] = $val["to_name"];
				$log[$key]["log_action_by"] = $admin->id;
				$log[$key]["log_action_by_name"] = $admin->name;
				$log[$key]["log_action_when"] = date("Y/m/d H:i:s");
			}
		}else{
			$log[0]["log_action_type"] = $arr["log_type"];
			$log[0]["log_action_to"] = $arr["to"];
			$log[0]["log_action_to_name"] = $arr["to_name"];
			$log[0]["log_action_by"] = $admin->id;
			$log[0]["log_action_by_name"] = $admin->name;
			$log[0]["log_action_when"] = date("Y/m/d H:i:s");
		}
		$this->db->insert_batch("admin_log",$log);
		if($this->db->affected_rows() <= 0){
			$this->error($this->db->error());
			return false;
		}
		return true;
	}

	public function grade_calc($point)
	{
		if($point <= 100 && $point >= 80){
			$grade = "A";
		}elseif($point <= 79 && $point >= 60){
			$grade = "B";
		}elseif($point <= 59 && $point >= 40){
			$grade = "C";
		}else{
			$grade = "D";
		}
		return $grade;
	}
}
 ?>
