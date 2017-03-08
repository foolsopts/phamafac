<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class MY_Controller extends MX_Controller
{
	//set the class variable.
	public $template = array();
	public $prehooks = array();
	public $module_data = array();
	public $view_path;
	public $asset_path;
	public $ci;
	public $controller;
	public $have_perm = FALSE;

	public function __construct($lang = NULL)
	{
			parent::__construct();
			$this->ci =& get_instance();
			$this->controller = $this->router->fetch_class();

			$this->core_aauth();

			global $RTR;
			$this->view_path = FCPATH."themes/templates/modules/";
			$this->asset_path = base_url()."assets/modules/";
			$this->_module = $RTR->fetch_module();
	}

	public function set_login_error($msg)
	{
		$cc["login_allow"] = FALSE;
		$cc["have_login"] = TRUE;
		$cc["error_msg"] = $msg;
		$this->session->set_userdata($cc);
	}

	public function core_aauth()
	{
		if($this->session->have_login){
			$cc["has_error"] = $this->session->error_msg;
			$this->setter_global($cc);
			$this->session->sess_destroy();
		}
		if($this->have_perm){
			//############ permission check ###################
			$this->config->load('permission');
			$perm = $this->config->item('group');
			$group = array();
			if($this->aauth->is_loggedin()){
				$user = $this->aauth->get_user();
				$group = $this->aauth->get_user_groups($user->id);
				$match_perm = 0;
				if(!empty($perm[$this->controller])){
					foreach($group as $user_group){
						if(strpos($perm[$this->controller], $user_group->name) !== FALSE || strpos($perm[$this->controller], "all") !== FALSE){
							$match_perm = 1;
							break;
						}
					}
					if($match_perm === 0){
						redirect(base_url()."login.html");
					}
				}else{
					redirect(base_url()."login.html");
				}
			}else{
				if(!empty($perm[$this->controller])){
					if(strpos($perm[$this->controller], 'all') === FALSE){
						redirect(base_url()."login.html");
					}
				}else{
					redirect(base_url()."login.html");
				}
			}
		}
		//##############################################//
	}

	public function setter_module($pos, $queue, $template, $data = array())
	{
		$token = RandomString();
		$this->ci->my_hooks[$pos][$queue][$this->_module."_".$queue]["template"] = APPPATH.'modules'.DIRECTORY_SEPARATOR.$this->_module.DIRECTORY_SEPARATOR."views/templates".DIRECTORY_SEPARATOR.$template;
		$this->ci->my_hooks[$pos][$queue][$this->_module."_".$queue]["data"] = $data;
		if(!empty($this->ci->global_var)){
			$this->ci->my_hooks[$pos][$queue][$this->_module."_".$queue]["data"]["global"] = $this->ci->global_var;
		}
	}

	public function getter_param($default, $param = array(), $type = "std")
  {
    $tmp = new stdClass;
    $cc = 0;
    $main = "";
    foreach($default as $key=>$val){
      if($cc === 0){
        $main = $key;
      }
      $tmp->$key = $val;
      $cc++;
    }
    if(is_array($param)){
      foreach($param as $key=>$val){
        $tmp->$key = $val;
      }
    }else{
      $tmp->$main = $param;
    }
		if($type === "std"){
			return $tmp;
		}
    return (array)$tmp;
  }

	public function setter_global($var)
	{
		foreach($var as $k=>$v){
			$this->ci->global_var[$k] = $v;
		}
	}

	public function setter_css($array = array())
	{
		foreach($array as $key=>$val){
			$this->ci->css[$key] = $val;
		}
	}
	public function setter_js($array = array())
	{
		foreach($array as $key=>$val){
			$this->ci->js[$key] = $val;
		}
	}
	//Load layout
	public function layout($param = array(), $page = NULL, $blank = FALSE, $data = NULL)
	{
		// $this->core_aauth();
		//***************** Startup Module *********************
		modules::run("top_menu","hook_top_menu",0,TRUE);
		/******************************************************/

		$default = array(
			"template" => "main",
			"page" => $this->controller,
			"blank" => FALSE,
			"data" => NULL,
		);
		$var = $this->getter_param($default, $param);
		$var->page = ($page !== NULL)?$page:$var->page;
		$var->balnk = ($blank !== FALSE)?$blank:$var->blank;
		$var->data = ($data !== NULL)?$data:$var->data;

		if(@count($this->my_hooks) > 0){
			//print_r($this->my_hooks);
			foreach($this->my_hooks as $k=>$v){
				if($k !== "current_controller"){
					$tp = $this->my_hooks[$k];
					ksort($tp);
				}
				foreach($tp as $a=>$b){
					foreach($b as $b_key => $b_val){
						$this->smarty->assign('current_controller', $var->page);
						$this->prehooks = $this->smarty->view($b[$b_key]["template"],$b[$b_key]["data"],TRUE);
						$this->template[$k][] = $this->prehooks;
					}
				}
			}
			$temp = $this->template;
			foreach($temp as $key => $val){
				foreach($temp[$key] as $v){
					@$combine[$key] .= (string)$v;
				}
			}
		}
		if(@count($this->css) > 0){
			$css_count = 0;
			foreach($this->css as $key_css=>$val_css){
				if($css_count > 0){
					@$css_combine .= "\t";
				}
				@$css_combine .= "<!-- $key_css -->\n";
				foreach($this->css[$key_css] as $val){
					@$css_combine .= "\t".'<link rel="stylesheet" type="text/css" href="'.$val.'"/>'."\n";
				}
				$css_count++;
			}
			$this->smarty->assign('css',$css_combine);
		}

		if(@count($this->js) > 0){
			$js_count = 0;
			foreach($this->js as $key_js=>$val_js){
				if($js_count > 0){
					@$js_combine .= "\t";
				}
				@$js_combine .= "<!-- $key_js -->\n";
				foreach($this->js[$key_js] as $val){
					@$js_combine .= "\t".'<script src="'.$val.'"></script>'."\n";
				}
				$js_count++;
			}
			$this->smarty->assign('js',$js_combine);
		}

		if($var->blank === TRUE){
			$this->index = FCPATH."themes/templates/draft.tpl";
		}else{
			$this->index = FCPATH."themes/templates/index.tpl";
		}

		if(@count($this->my_hooks) <= 0){
			$this->smarty->assign('global',$this->global_var);
			$this->smarty->assign('current_controller', $var->page);
		}
		if($var->data !== NULL){
			$this->smarty->assign('local',$var->data);
		}
		$this->smarty->assign('include',FCPATH."themes/templates/pages/".$var->template.".tpl");
		if(!empty($combine)){
			$this->smarty->view($this->index, $combine);
		}else{
			$this->smarty->view($this->index);
		}
	}
}
