<?php
class Log_model extends CI_Model {
	public $dbhr;

	public function __construct() {
		$this->dbhr  = $this->load->database('admin', TRUE);
	}
	public function save_log($type, $to, $by, $to_name = NULL, $by_name = NULL)
  {
    $log = array(
    	'log_action_type' => $type,
			'log_action_to' => $to,
			'log_action_to_name' => $to_name,
			'log_action_by' => $by,
			'log_action_by_name' => $by_name,
			'log_action_when' => date("Y/m/d H:i:s")
		);
		$this->dbhr->insert('admin_log',$log);
  }
}
