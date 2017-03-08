<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Info extends MY_Controller{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }

  function index()
  {
    $this->layout("info");
  }

}
