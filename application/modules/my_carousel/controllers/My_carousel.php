<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class My_carousel extends MY_Controller {
	public $ci;
	public $db;
	public $path;
	public $dir_name;
	public $template = "my_slide";
	public $js = "head_slide";
	public $css = "my_slide";
	public $mode = "slide";

	public function __construct()
	{
		parent:: __construct();
		global $RTR;
		$this->_module = $RTR->fetch_module();
		$this->ci =& get_instance();
		// $js["my_carousel"] = array(
		// 	"//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js",
		// 	base_url()."assets/modules/my_carousel/js/config.js"
		// );
		//
		// $css["my_carousel"][] = "//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.css";
		// $this->setter_js($js);
		// $this->setter_css($css);
	}

	function _remap()
	{
		echo 'No direct access allowed';
	}

	public function index($position = NULL, $que = 0, $param = array())
	{
		///////////////////Default Parameters///////////////
		$default = array(
			"navigator"=>"",
			"path"=>FCPATH."_sandboxs/my_box/",
			"dir_name"=>"",
			"mode"=>"slide"
		);
		$var = $this->getter_param($default,$param);
		////////////////////////////////////////////////////

		$data["content"] = $slide;
		$template =  'carousel.tpl';
		$this->setter_module($position,$que,$template);
	}
}
?>
