<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bread_crumb extends MX_Controller {
	public $ci;

	public function __construct()
	{
		parent:: __construct();
		global $RTR;
		$this->_module = $RTR->fetch_module();
		$this->ci =& get_instance();
	}

	public function index($position = NULL, $que = 0, $hide = NULL)
	{
    $i = 1;
		$hidden = array();
		$last = "";
    while(1) {
      if($hide !== NULL){
				if(in_array($i, $hide)){
					do {
						$hidden[$i] = $this->uri->segment($i);
						$i++;
					} while (in_array($i, $hide));
				}
      }
      if(empty($this->uri->segment($i))){
        break;
      }
      $result["visible"]["name"][$i] = urldecode($this->uri->segment($i));
			$last = urldecode($this->uri->segment($i));
      $i++;
    }
		$result["hidden"] = $hidden;
		$union = $result["visible"]["name"] + $result["hidden"];
		uasort($union, function($a, $b){
		    return $a - $b;
		});
		$combine = $union;
		ksort($combine);
		$url = "";
		$split = "";
		foreach($result["visible"]["name"] as $key=>$val){
			$ii = 1;
			while($ii !== $key){
				if($ii !== 1){
					$split = "/";
				}
				$url = $url.$split.$combine[$ii];
				$ii++;
			}
			if(empty($url)){
				$split2 = "";
			}else{
				$split2 = "/";
			}
			$result["visible"]["url"][$key] = $url.$split2;
			$url = "";
		}


		$result["combine"] = $combine;
		$result["active"] = $last;
    $this->ci->my_hooks->$position->list[$que] = APPPATH.'modules/'.$this->_module.'/views/templates/bread_crumb.tpl';
		$this->ci->data["module_data"][$this->_module] = $result;
		$this->ci->my_hooks->$position->module_name[$que] = $this->_module;
  }
}
