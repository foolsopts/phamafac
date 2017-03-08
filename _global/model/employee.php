<?php
class Employee_model extends CI_Model {
	public $dbhr;
	public $upload_target;
	public $ci;

	public function __construct() {
		parent::__construct();
		$this->ci =& get_instance();
		$this->dbhr  = $this->load->database('admin', TRUE);
		$upload_folder = $this->config->item('upload_folder');
		$this->upload_target  = dirname(FCPATH)."/".$upload_folder."/"."pcgadmin/employee/";
	}

	public function get_emp_info($id,$by = "A.profile_id")
	{
		$stmt = $this->dbhr
			->from('employee_profile A')
			->where($by,$id)
			->join('workgroup B','A.profile_workgroup_id = B.workgroup_id')
			->join('warehouse C','A.profile_warehouse_id = C.warehouse_id')
			->join('level D','A.profile_level_id = D.level_id')
			->order_by('A.profile_id','DESC')
			->get();
		if($stmt->num_rows() <= 0){
			return false;
		}
		return $stmt->result();
	}

	public function get_staff_list($where)
	{
		$stmt = $this->dbhr
			->from('employee_profile A')
			->where($where)
			->join('workgroup B','A.profile_workgroup_id = B.workgroup_id')
			->join('warehouse C','A.profile_warehouse_id = C.warehouse_id')
			->join('level D','A.profile_level_id = D.level_id')
			->order_by('A.profile_id','DESC')
			->get();

		if($stmt->num_rows() <= 0){
			return false;
		}
		if($stmt->num_rows() == 1){
			return $stmt->result()[0];
		}else{
			return $stmt->result();
		}
	}

	public function emp_get_list($param = array())
	{
		$default = array(
			"select" => "*",
			"select2" => FALSE,
			"where" => FALSE,
			"where_in" => FALSE,
			"where_not_in" => FALSE,
			"show_blacklist" => FALSE,
			"show_quit" => FALSE
		);
		$var = getter_param($default,$param);

		$this->dbhr
			->select('MIN(A.profile_start_date) AS min_year');
		if(!$var->show_blacklist){
			$this->dbhr->where('A.profile_is_blacklist !=',1);
		}
		if(!$var->show_quit){
			$this->dbhr->where('A.profile_is_quit !=',1);
		}
		if($var->where){
			$this->dbhr->where($var->where);
		}
		if($var->where_in){
			$this->dbhr->where_in($var->where_in[0],$var->where_in[1]);
		}
		if($var->where_not_in){
			$this->dbhr->where_not_in($var->where_not_in[0],$var->where_not_in[1]);
		}
		$min_year_sql = $this->dbhr->get_compiled_select('employee_profile A');

		$this->dbhr
			->select($var->select);
		if($var->select2){
			$this->dbhr->select($var->select2);
		}
		$this->dbhr->from('employee_profile A')
			->join("($min_year_sql) A1","A.profile_start_date != ''")
			->join('workgroup B','A.profile_workgroup_id = B.workgroup_id')
			->join('warehouse C','A.profile_warehouse_id = C.warehouse_id')
			->join('level D','A.profile_level_id = D.level_id');
		if(!$var->show_blacklist){
			$this->dbhr->where('A.profile_is_blacklist !=',1);
		}
		if(!$var->show_quit){
			$this->dbhr->where('A.profile_is_quit !=',1);
		}
		if($var->where){
			$this->dbhr->where($var->where);
		}
		if($var->where_in){
			$this->dbhr->where_in($var->where_in[0],$var->where_in[1]);
		}
		if($var->where_not_in){
			$this->dbhr->where_not_in($var->where_not_in[0],$var->where_not_in[1]);
		}
		$stmt = $this->dbhr->get();
		// echo $this->dbhr->last_query();
		// die();

		$return = array(
			"num_rows" => $stmt->num_rows(),
			"data" => $stmt->result()
		);
		return $return;
	}
}
 ?>
