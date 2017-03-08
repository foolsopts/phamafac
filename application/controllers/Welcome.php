<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends MY_Controller{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }

  function index()
  {
    // $headslide = array(
    //   "dir_name" => "headslide"
    // );
    modules::run('my_slide','hook_head_slide',0);
    modules::run('my_carousel','hook_brand_show',0);
    $this->layout("main");
  }

}
