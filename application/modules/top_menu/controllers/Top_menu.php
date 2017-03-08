<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Top_menu extends MY_Controller {
  public $top_menu;

	public function __construct()
	{
		parent:: __construct();
    $this->config->load('nav_menu');
    $this->top_menu = $this->config->item('nav_menu');
    //print_r($this->aauth->get_user());
	}

	public function index($position = NULL, $que = 0, $param = array())
	{
    $default = array(
      "auth" => FALSE
    );
    $var = $this->getter_param($default, $param);
    if(count($this->top_menu) > 0){
      if($var->auth){
        if(!$this->aauth->is_loggedin()){
          $this->top_menu = array();
        }else{
          $user_data = $this->aauth->get_user();
          $user_group = $this->aauth->get_user_groups($user_data->id);
          //print_r($user_group);
          foreach($this->top_menu as $key=>$val){
            $auth_found = 0;
            //print_r($filter);
            if(!empty($val["auth_class"])){
              foreach($user_group as $v){
                if(in_array($v->name, $val["auth_class"])||in_array("all", $val["auth_class"])){
                  $auth_found = 1;
                  break;
                }
              }
              if($auth_found === 0){
                unset($this->top_menu[$key]);
              }
            }
          }
        }
      }
    }

		$data["content"] = $this->top_menu;
		//$this->smarty->display(APPPATH.'modules'.DIRECTORY_SEPARATOR.$this->_module.DIRECTORY_SEPARATOR."views/templates".DIRECTORY_SEPARATOR.'top_menu.tpl',$data);
		$this->setter_module($position, $que, 'top_menu.tpl',$data);
	}
}
?>
