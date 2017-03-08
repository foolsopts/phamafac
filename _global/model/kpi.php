<?php
class Kpi_model extends CI_Model {
	public $admin;
	public $hr;
	public $ci;
	public $action;
	public $errors;

	public function __construct() {
		$this->ci =& get_instance();
		$this->admin  = $this->load->database('admin', TRUE);
		$this->log_kpi = $this->load->database('log',TRUE);
	}

	public function get_kpi_list($data)
	{
		$stmt = $this->admin
			->where_in('profile_id',$data)
			->get('employee_profile');
		return $stmt->result();
	}



	public function save_kpi_log($data)
	{
		$result = $data["result"]["data"][0];
		$post = $data["post"];
		$admin = $this->aauth->get_user();
		$insert_ids = array();
		$update_cap = array();
		$update = array();
		$log = array();

		$var = array(
			"table" => "employee_profile",
			"select" => "profile_id, profile_ref_id, profile_point",
			"where_in" => array('profile_id',$post["emp_list"])
		);
		if(!$emp_list = $this->gmodel->get_list($var)){
			echo json_stat("fail",$this->gmodel->errors);
			die();
		}

		switch($result->header_cond){
			case 1:
				$range["start"] = date('Y-m-01');
				$range["end"] = date('Y-m-t 23:59:59');
			break;

			case 2:
				$date_range = get_dates_of_quarter();
				$range["start"] = $date_range["start"]->format('Y-m-d H:i:s');
				$range["end"] = $date_range["end"]->format('Y-m-d H:i:s');
			break;

			case 3:
				$range["start"] = date('Y-01-01');
				$range["end"] = date('Y-12-t 23:59:59');
			break;

			default:
				echo json_stat("fail","ขออภัย..ไม่พบวันสรุปคะแนน");
				die();
			break;
		}

		$this->log_kpi->trans_begin();
		$this->admin->trans_begin();
		$round = 0;
		foreach($emp_list["data"] as $val){
			$insert = array(
        'kpi_log_head_id' => $result->header_id,
				'kpi_log_follow_start' => $range["start"],
				'kpi_log_follow_end' => $range["end"],
        'kpi_log_add_admin_id' => $admin->id,
        'kpi_log_add_admin_name' => $admin->name,
				'kpi_log_emp_id' => $val->profile_id,
				'kpi_log_action' => $result->header_cat,
				'kpi_log_point' => $result->header_point,
				'kpi_log_caption' => $result->header_caption
	    );

			$update[$round] = array(
				'profile_id' => $val->profile_id,
				'profile_edit_admin_id' => $admin->id,
				'profile_edit_admin_name' => $admin->name,
				'profile_edit_date' => date('Y-m-d H:i:s')
			);

			switch($result->header_cat){
				case 1:
					$this->action = "Motivation_add";
					$update[$round]["profile_latest_motivation"] = date("Y-m-d H:i:s");
				break;

				case 2:
					$this->action = "kpi_add";
					$update[$round]["profile_latest_kpi"] = date("Y-m-d H:i:s");
				break;

				default:
					echo json_stat("fail","ขออภัย..รูปแบบไม่ถูกต้อง");
					die();
				break;
			}

			$log[] = array(
				"log_type" => $this->action,
				"to" => $val->profile_id,
				"to_name"=> $val->profile_ref_id,
			);

			$this->log_kpi->insert('kpi_log', $insert);
			$insert_ids[] = $this->log_kpi->insert_id();
			$round++;
		}
		if($this->log_kpi->trans_status() === FALSE){
			$this->log_kpi->trans_rollback();
			echo json_stat("fail",$this->log_kpi->error());
			die();
		}

		if(!$this->gmodel->save_log($log)){
			$this->log_kpi->trans_rollback();
			echo json_stat("fail",$this->gmodel->errors);
			die();
		}

		$this->admin
			->update_batch("employee_profile",$update,"profile_id");
		if($this->admin->affected_rows() <= 0){
			$this->log_kpi->trans_rollback();
			echo json_stat("fail",$this->admin->error());
			die();
		}

		if(!empty($post["have_caption"])){
			if(empty($post["description"])){
				$this->log_kpi->trans_rollback();
				$this->admin->trans_rollback();
				echo json_stat("fail","โปรดกรอกคำอธิบายรายการ");
				die();
			}
			$path = $this->config->item('kpi_mgr_doc_path')."/".date('Ymd')."/";
			$fname = md5(time()).".txt";
			if(!push_file($fname,$path,$post["description"])){
				$this->log_kpi->trans_rollback();
				$this->admin->trans_rollback();
				echo json_stat("fail","cannot write kpi doc.");
				die();
			}
			foreach($insert_ids as $id){
				$update_cap[] = array(
					'kpi_log_id' => $id,
					'kpi_log_doc' => date('Ymd')."/".$fname
				);
			}
			$this->log_kpi->update_batch("kpi_log",$update_cap,"kpi_log_id");
			if($this->log_kpi->affected_rows() <= 0){
				$this->log_kpi->trans_rollback();
				$this->admin->trans_rollback();
				echo json_stat("fail",$this->log_kpi->error());
				die();
			}
		}
		$this->log_kpi->trans_commit();
		$this->admin->trans_commit();
		echo json_stat("success",$result->header_cat);
		die();
	}

	public function calc_point($mode,$emp,$c_point,$date=array())
	{
		$default = array(
			"kpi_start" => date('Y-m-01'),
			"kpi_end" => date('Y-m-t 23:59:59'),
			"mo_start" => date('Y-01-01'),
			"mo_end" => date('Y-12-t 23:59:59')
		);
		$var = getter_param($default,$date);

    $mode = (int)$mode;
    if($mode === 1){
  		$where = array(
  			"kpi_log_action" => $mode,
  			"kpi_log_emp_id" => $emp,
  			"kpi_log_add_date >=" => $var->mo_start,
  			"kpi_log_add_date <=" => $var->mo_end
  		);
    }else{
      $where = array(
  			"kpi_log_action" => $mode,
  			"kpi_log_emp_id" => $emp,
  			"kpi_log_add_date >=" => $var->kpi_start,
  			"kpi_log_add_date <=" => $var->kpi_end
  		);
    }

		$stmt = $this->log_kpi
			->select_sum("kpi_log_point")
			->where($where)
			->get("kpi_log");
		if($stmt->num_rows() == 0){
			return 0;
		}
		$point = $stmt->result()[0]->kpi_log_point;
		switch($mode){
			case 1:
        $where = array(
          "vl_emp_id"=>$emp,
          "vl_date >=" => $var->mo_start,
    			"vl_date <=" => $var->mo_end
        );
        $stmt = $this->log_kpi
          ->select_sum('vl_point')
          ->where($where)
          ->get('voucher_log');
				if($stmt->num_rows() > 0){
        	$used = $stmt->result()[0]->vl_point;
					$result = (($c_point+$point)-$used < 0)?0:($c_point+$point)-$used;
				}else{
					$result = 0;
				}
				return $result;
			break;

			case 2:
				return ($c_point-$point < 0)?0:$c_point-$point;
			break;
		}
	}

	public function get_point_history($mode, $id, $year = NULL)
	{
		if(!isset($year))
        $year = date('Y');

		$where = array(
			"kpi_log_emp_id" 			=>	$id,
			"kpi_log_action" 			=>	$mode,
			"kpi_log_add_date >=" =>	date($year.'-01-01'),
			"kpi_log_add_date <=" =>	date($year.'-12-t 23:59:59')
		);
		$log = $this->log_kpi
			->where($where)
			->get('kpi_log');
		if($log->num_rows() == 0){
			return false;
		}
		return $log->result()[0];
	}

	public function point_history($mode,$where = FALSE){
		$this->log_kpi
			->select_sum("A.kpi_log_point","total_point");
		if($where){
			$this->log_kpi->where($where);
		}
		$sum_kpi = $this->log_kpi
			->get_compiled_select('kpi_log A');
		$this->log_kpi
				->from('kpi_log A')
				->join("($sum_kpi) B","B.total_point >= 0");
		if($where){
			$this->log_kpi->where($where);
		}
		$stmt = $this->log_kpi->get();
		$return = array(
			"num_rows" => $stmt->num_rows(),
			"data" => $stmt->result()
		);
		return $return;
	}
}
?>
