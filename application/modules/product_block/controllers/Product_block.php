<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_block extends MY_Controller {

	public $ci;
  public $ims;
  public $onWeb = 1;
  public $price_mode;
  public $price_prepare;
	public $limit_string;
	public $un_control;
	public $module_id;
	public $ref = 0;
	public $back_store;
	public $contact_tel;
	public $cookie_key;
	public $out_of_stock_bypass = TRUE;
	public $single_image = 0;
	public $nomalize_img = FALSE;

	/////////////INDEX DEFAULT PARAMETERS///////////////

	public $limit = 20;
	public $col = 4;
	public $pagination = FALSE;
	public $cat = NULL;
	public $brand = NULL;
	public $order = "product_add_date";
	public $status_input = FALSE;
	public $read_only = FALSE;
	public $groupBy = array(
		"product_name",
		"product_brand",
		"product_group_name",
		"product_model"
	);
	public $amount_days_new = FALSE;
	public $mode = "default";

	///////////BLOCK DETAIL DEFAULT PARAMETERS//////////

	public $block_detail_mode = "compact";
	public $block_detail_id = NULL;

	////////////////////////////////////////////////////



	public function __construct()
	{
		parent:: __construct();
		global $RTR;
		$this->_module = $RTR->fetch_module();
		$this->ci =& get_instance();
    $this->ims = $this->load->database('ims', TRUE);
    $this->price_mode = $this->config->item('price_mode');
    $this->price_prepare = $this->config->item('price_prepare');
		$this->back_store = $this->config->item('back_store');
		$this->contact_tel = $this->config->item('contact');
		$this->cookie_key = $this->config->item('cookie_key');
		$this->load->helper('cookie');
	}

	public function index($position = NULL, $que = 0, $param = array())
	{
		///////////////////Default Parameters///////////////
		foreach($param as $key=>$val){
			$this->$key = $val;
		}
		////////////////////////////////////////////////////
		$module_name = $this->_module;
		$this->limit_string = $this->limit;
		$this->module_id = $que;

		if($this->input->get('ref')){
			$this->ref = (int)$this->input->get('ref');
		}
    //////Sub query///////////////////
		$this->ims
      ->select('MAX(bb.product_add_date) AS MaxDate')
      ->where('bb.product_show_on_web', $this->onWeb);
		foreach($this->groupBy as $val){
			$this->ims->group_by("bb.".$val);
		}
    $this->ims->from('product bb');
		$this->requestTool("bb");
		$subquery = $this->ims->get_compiled_select();
		$this->ims->reset_query();
		//////Main query/////////////////////////////////////////
		if($this->order !== "rand"){
			$order = "A.".$this->order;
		}else{
			$order = "rand()";
		}
		$this->ims
      ->select('A.product_no, A.product_name, A.product_image, A.product_add_date, A.product_update, A.product_code, A.product_brand, A.product_model, A.product_description')
      ->select('A.' . $this->price_mode . ' AS price_default')
      ->select('A.'.$this->price_prepare.' AS price_prepare')
      ->join("($subquery) B", "A.product_add_date = B.MaxDate", "inner")
      ->where('A.product_show_on_web', $this->onWeb)
			->order_by($order,"DESC");
		foreach($this->groupBy as $val){
			$this->ims->group_by("A.".$val);
		}
    $this->ims->from('product A');
		$this->requestTool("A");
		if($this->cat !== NULL){
			foreach($this->cat as $key=>$val){
				$this->ims->where('A.'.$key,$val);
				$this->ci->data["module_data"]["global"]["sidebar_data"] = $key."#".$val;
			}
		}
		if($this->brand !== NULL){
			$this->ims->where("A.product_brand", $this->brand);
		}
		if($this->status_input !== FALSE){
			$this->ims->where('A.product_status_input',$this->status_input);
		}
		///////////////////////////////////////////////////////*/
    $stmt = $this->ims->get();
		// echo $this->ims->last_query();
		// //print_r ($stmt);
		// die();
    $total_row = $stmt->num_rows();
		$next_query = $stmt->result_id->queryString;

    //////////////////Real Query/////////////////////////////
		$next_query = $next_query." limit ".$this->limit_string;
		$stmt = $this->ims->query($next_query);
		//echo $next_query;
		$result = $stmt->result();
    ////////////////////////////////////////////////////////
		$temp = array();
		foreach ($result as $val) {
			$val->friendly = friendly($val->product_name);
			if(empty($val->product_image)){
				$val->image_url = base_url()."assets/modules/".$this->_module."/img/no_photo.png";
			}else{
				if($this->nomalize_img === TRUE){
					$val->image_url = whiteSpace($this->back_store."/image_product/".$val->product_no."/".$val->product_image);
				}else{
					$val->image_url = $this->back_store."/image_product/".$val->product_no."/".$val->product_image;
				}
			}
			if($this->amount_days_new !== FALSE){
				if($this->order === "rand"){
					$date_target = "product_update";
				}else{
					$date_target = $this->order;
				}
				$date1	=	date_create(date('Y-m-d',strtotime($val->$date_target)));
				$date2	=	date_create(date('Y-m-d'));
				$diff		=	date_diff($date1,$date2);
				//echo date('Y-m-d');
				$tdiff = "old";
				if($this->amount_days_new !== FALSE){
					if($diff->format("%a") <= $this->amount_days_new){
						$tdiff = "new";
					}
				}
				$val->is_new = $tdiff;
			}
			$temp["product"][] = $val;
		}
		$temp["total_p"] = ceil($total_row / $this->limit);
		$temp["current_p"] = $this->input->get('p');
		$temp["queryString"] = $next_query;
		$temp["column"] = 12/$this->col;
		$temp["id"] = $que;
		if($this->pagination !== TRUE){
			$this->pagination = NULL;
			$temp["pagination"] = 0;
		}else{
			$this->pagination = base_url()."assets/plugins/twbspagination/my-pagination.js";
			$temp["pagination"] = 1;
		}
		$temp["currentURI"] = basename(rawurldecode($_SERVER['REQUEST_URI']));
		$temp["backstore"] = $this->back_store;

		$this->ci->css[$module_name][] = base_url()."assets/modules/".$this->_module."/css/product_block.css";

		$this->ci->js[$module_name] = array(
			base_url()."assets/modules/".$this->_module."/js/product_block.js",
			$this->pagination
		);
		$key_name = RandomString();
		$this->ci->css[$key_name] = array(

		);
		$this->ci->js[$key_name] = array(

		);
		if($this->mode === "default"){
			$tpl = "product_block.tpl";
		}else{
			$this->ci->js[$module_name][] = base_url()."assets/modules/".$this->_module."/js/mode/".$this->mode.".js";
			$tpl = $this->mode.".tpl";
		}
		if($this->navigator === "yes"){
			//$this->ci->my_hooks->$position->list[$que] = APPPATH.'modules/'.$module_name.'/views/templates/carouselwithbutton.tpl';
			$tpl =  "carouselwithbutton.tpl";
		}else{
			//$this->ci->my_hooks->$position->list[$que] = APPPATH.'modules/'.$module_name.'/views/templates/'.$tpl;
		}
		$data["content"] = $temp;
		//$this->ci->data["module_data"][$key_name] = $temp;
		//$this->ci->my_hooks->$position->module_name[$que] = $key_name;
		//$this->setter_module($position,$que,$tpl,$temp);
		$this->setter_module($position, $que,$tpl,$data);
	}
	public function block_detail($position = NULL, $que = 0, $param)
	{
		///////////////////Default Parameters///////////////
		foreach($param as $key=>$val){
			$this->$key = $val;
		}
		////////////////////////////////////////////////////
    $key_name = RandomString();
		$this->ci->css[$key_name] = array(
			"https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.3.1/css/swiper.min.css"
		);
    $this->ci->js[$key_name] = array(
			"https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.3.1/js/swiper.min.js",
			base_url()."assets/modules/".$this->_module."/js/block_detail/core.js",
			base_url()."assets/modules/".$this->_module."/js/block_detail/product_detail.js"
		);
		$data = array();
		if($this->block_detail_mode === "full"){
			$data["detail"] = $this->detail($this->block_detail_id,TRUE);
			$this->ci->data["module_data"]["product_block"]["p_name"] = $data["detail"]["product"][0]->product_name;
			$this->ci->js[$key_name] = array(

			);
		}else{
			$this->ci->css[$this->_module][] = base_url()."assets/modules/".$this->_module."/css/modal/modal.css";
		}
		$data["select_list"] = $this->getSelectList($this->block_detail_id,TRUE);
		$data["contact_tel"] = $this->contact_tel;
		$this->ci->data["module_data"][$key_name] = $data;
    $this->ci->my_hooks->$position->list[$que] = APPPATH.'modules/'.$this->_module.'/views/templates/block_detail/'.$this->block_detail_mode.'.tpl';
		//$this->ci->data["module_data"][$key_name] = $slide;
		$this->ci->my_hooks->$position->module_name[$que] = $key_name;
  }
	public function summary($position = NULL, $que = 0)
	{
		$item = array();
		$sum_amount = 0;
		$list = get_cookie($this->cookie_key);
		if (!empty($list)) {
			$i = 0;
			$ii = 0;
			$list = stripslashes($list);
			$list_item = json_decode($list, true);
			foreach ($list_item as $key => $value) {
				$result = $this->detail($key, FALSE, TRUE,"product_no,product_name,product_code,product_image");
				foreach ($result as $row) {
					$row->q = $list_item[$key];
					$row->tamount = $list_item[$key]*$row->price_default;
					$sum_amount = $row->tamount+$sum_amount;
					$item["p_list"][] = $row;
					$i = $i + $list_item[$key];
				}
				$ii++;
			}
			$item["total"] = $i;
			$item["count_cat"] = $ii;
		}
		$key_name = RandomString();
		$this->ci->js[$this->_module] = array(
			base_url()."assets/modules/".$this->_module."/js/summary/summary.js"
		);
		$this->ci->css[$this->_module] = array(
			base_url()."assets/modules/".$this->_module."/css/summary/summary.css"
		);
		$item["sum_amount"] = $sum_amount;
		$item["totalCart"] = $this->addToCart(NULL, NULL, NULL, 24680);
		$this->ci->data["module_data"][$key_name] = $item;
    $this->ci->my_hooks->$position->list[$que] = APPPATH.'modules/'.$this->_module.'/views/templates/summary/summary.tpl';
		$this->ci->my_hooks->$position->module_name[$que] = $key_name;
	}
	public function cart()
	{
		$key_name = RandomString();
		$this->ci->data["module_data"]["global"]["global_Cart"] = $this->addToCart(NULL, NULL, NULL, 24680);
	}
	public function searchMode($text, $own)
	{
		$search = rawurldecode($text);
		$this->ims->group_start()->like($own . "product_name", $search)->or_like(array(
			$own . "product_color" => $search,
			$own . "product_size" => $search,
			$own . "product_description" => $search,
			$own . "product_brand" => $search,
			$own . "product_model" => $search,
			$own . "product_code" => $search
		))->group_end();
		//$this->parser->assign('searchStr', $search);
	}
	public function scopeMode($min = FALSE, $max = FALSE, $own = NULL)
	{
		if ($max && $min) {
			$this->ims->where($own . $this->price_mode . " BETWEEN $min AND $max");
			$this->ims->order_by($this->price_mode, "ASC");
		} elseif ($min && !$max) {
			$this->ims->where($own . $this->price_mode . " >=", $min);
			$this->ims->order_by($this->price_mode, "ASC");
		} elseif (!$min && $max) {
			$this->ims->where($own . $this->price_mode . " <=", $max);
			$this->ims->order_by($this->price_mode, "DESC");
		}
		//$this->parser->assign('min', $min);
		//$this->parser->assign('max', $max);
	}
	public function requestTool($own = NULL)
	{
		if($this->read_only === FALSE){
				if($this->ref === $this->module_id){
					if($this->input->get('p')){
						$page = $this->input->get('p');
						if ($page <= 1) {
							$page = 0;
						} else {
							$page = ($page * $this->limit) - $this->limit;
						}
						$this->limit_string = $page.",".$this->limit;
					}
					if ($own !== NULL) {
						$own = $own . ".";
					}
					if ($this->input->get('s')) {
						$search = $this->input->get('s');
						$this->searchMode($search, $own);
					}
					if ($this->input->get('l')) {
						$arr = explode(',', $this->input->get('l'));
						if (empty($arr[0])) {
							$arr[0] = 0;
						}
						if (empty($arr[1])) {
							$arr[1] = FALSE;
						}
						$this->scopeMode($arr[0], $arr[1], $own);
					}
				}
		}
	}
	public function getSelectList($id = NULL, $bypass = NULL)
	{

		//$this->isAjax($bypass);

		if ($temp = $this->input->post('id')) {
			$id = $temp;
		}
		if ($id === NULL) {
			//header("location: " . FCPATH . "shop.html");
		}

		$this->ims->where('product_no', $id);
		$stmt = $this->ims->get('product');
		$result = $stmt->result();

		$this->ims->select('product_no,product_code,product_size,product_color,product_name,product_balance');
		$this->ims->select($this->price_mode . ' AS price_default');
		$where = array(
			"product_name" => $result[0]->product_name,
			"product_show_on_web" => $this->onWeb
		);
		$this->ims->where($where);
		foreach($this->groupBy as $val){
			$this->ims->where($val,$result[0]->$val);
		}
		$stmt = $this->ims->get('product');

		foreach ($stmt->result() as $row) {
			if (empty($row->product_size)) {
				$row->product_size = "ไม่ระบุ";
			}
			if (empty($row->product_color)) {
				$row->product_color = "ไม่ระบุ";
			}
			if (empty($row->price_default)) {
				$row->price_default = "ไม่ระบุ";
			} else {
				$row->price_default = number_format($row->price_default, 2, '.', ',');
			}
			$option[] = $row;
		}
		if ($bypass !== NULL) {
			return $option;
		}
		echo json_encode($option);
	}
  public function detail($id = NULL, $view = FALSE, $bypass = NULL, $select = "*")
	{
		//$this->isAjax($bypass);

		if ($temp = $this->input->post('id')) {
			$id = $temp;
		}
		if ($id === NULL) {
			header("location: " . FCPATH . "product.html");
		}
		$this->ims->select($select);
		$this->ims->select($this->price_mode . ' AS price_default');
		$this->ims->select('product_balance,product_image,product_name');
		$where = array(
			"product_no" => $id,
			"product_show_on_web" => $this->onWeb
		);
		$this->ims->where($where);
		$stmt = $this->ims->get('product');
		if($stmt->num_rows() > 0){
			$result = $stmt->result();
			$image = $result[0]->product_image;
			$result[0]->product_image = NULL;
			$result[0]->product_image = $this->getImageList($result[0]->product_no,$image);
			if(count($result[0]->product_image) <= 1){
				$result[0]->single_image = 1;
			}else{
				$result[0]->single_image = 0;
			}
			$result[0]->friendly = preg_replace(array(
				"`[^a-z0-9ก-๙เ-า]`i",
				"`[-]+`"
			), "_", $result[0]->product_name);
			$result[0]->out_of_stock_bypass = 0;
			if($this->out_of_stock_bypass){
				$result[0]->out_of_stock_bypass = 1;
			}
		}else{
			$result = NULL;
		}
		$arproduct = $result;
		//print_r($arproduct);
		//echo json_encode($this->getSelectList($id));
		if ($bypass !== NULL) {
			return $arproduct;
		}
		if ($view !== FALSE) {
			$data["product"] = $arproduct;
			//$this->parser->parse('extends:opts/tab_detail/tab_detail.tpl', $data);
			return $data;
		}
		echo json_encode($arproduct);
	}
	public function preview($id = NULL, $bypass = NULL)
	{
		//$this->isAjax($bypass);
		if ($temp = $this->input->post('id')) {
			$id = $temp;
		}
		if ($id === NULL) {
			//header("location: " . FCPATH . "shop.html");
		}
		$this->ims->select('product_image, product_no');
		$where = array(
			"product_no" => $id,
			"product_show_on_web" => $this->onWeb
		);
		$this->ims->where($where);
		$stmt = $this->ims->get('product');
		$result = $stmt->result();
		$image = $result[0]->product_image;
		$result[0]->product_image = NULL;
		$result[0]->product_image = $this->getImageList($result[0]->product_no,$image);
		$arproduct = $result;
		//print_r($arproduct);
		//echo json_encode($this->getSelectList($id));
		if ($bypass !== NULL) {
			return $arproduct;
		}
		$data["product"] = $arproduct;
		$this->smarty->view(APPPATH.'modules/'.$this->_module.'/views/templates/block_detail/product_preview.tpl',$data);
	}
	public function getImageList($no = NULL, $fimg)
	{
		if (!empty($fimg)) {
			$sub_img = directory_map(dirname(FCPATH)."/".str_replace("http://","",$this->back_store).'/image_product/'.$no.'/'.$no);
			$img = array();
			$img[0] = $this->back_store . "/image_product/" . $no . "/" . $fimg;
			if(is_array($sub_img)){
				$i = 1;
				foreach($sub_img as $simg){
					$img[$i] = $this->back_store . "/image_product/" . $no . "/".$no."/". $simg;
					$i++;
				}
			}
		} else {
			$img[0] = base_url()."assets/modules/product_block/img/no_photo.png";
		}
		//print_r($img);
		return $img;
	}
	public function addToCart($IntNo = NULL, $IntQt = NULL, $mode = NULL, $bypass = NULL)
	{
		//$this->isAjax($bypass);

		switch ($mode) {
			case "edit":
				if ($IntNo !== NULL && $IntQt !== NULL) {
					$list = get_cookie($this->cookie_key);
					$list = stripslashes($list);
					$list_item = json_decode($list, true);
					if (array_key_exists($IntNo, $list_item)) {
						$list_item[$IntNo] = $IntQt;
						$add_item = json_encode($list_item);
						setcookie($this->cookie_key, $add_item, time() + (86400 * 30), "/");
						return true;
					}
				}
				break;

			case "del":
				if ($IntNo !== NULL) {
					$list = get_cookie($this->cookie_key);
					$list = stripslashes($list);
					$list_item = json_decode($list, true);
					if (array_key_exists($IntNo, $list_item)) {
						unset($list_item[$IntNo]);
						$add_item = json_encode($list_item);
						setcookie($this->cookie_key, $add_item, time() + (86400 * 30), "/");
						return true;
					}
				}
				break;
		}

		if ($IntNo !== NULL && $IntQt !== NULL) {
			$cart_items = array();
			$this->ims->where('product_no', $IntNo);
			$stmt = $this->ims->get('product');
			$stmt = $this->detail($IntNo,FALSE,TRUE,"product_no");
			if ($stmt !== NULL) {
				if($stmt[0]->out_of_stock_bypass !== 1){
					if($stmt[0]->product_balance <= 0){
						echo "Sorry this product out of stock.";
						return false;
					}
				}
				$list = get_cookie($this->cookie_key);
				if (empty($list)) {
					$cart_items[$IntNo] = 0;
				} else {
					//print_r($list);
					$list = stripslashes($list);
					$cart_items = json_decode($list, true);
					//echo $list;
				}
				if (array_key_exists($IntNo, $cart_items)) {
					$cart_items[$IntNo] = $cart_items[$IntNo] + $IntQt;
				} else {
					$cart_items[$IntNo] = $IntQt;
				}
				//print_r($cart_items);
				$totalQT = array_sum($cart_items);
				$add_cookie = json_encode($cart_items);
				setcookie($this->cookie_key, $add_cookie, time() + (86400 * 30), "/");
				//set_cookie($this->cookie_key, $add_cookie, time() + (86400 * 30), "/");
				echo $totalQT;
				return true;
			}
			header("location: " . FCPATH . "product.html");

		} else {
			$list = get_cookie($this->cookie_key);
			if (empty($list)) {
				if ($bypass !== NULL) {
					return 0;
				}
				echo 0;
			} else {
				$list = stripslashes($list);
				$cart_items = json_decode($list, true);
				if ($bypass !== NULL) {
					return array_sum($cart_items);
				}
				echo array_sum($cart_items);
			}
		}
	}
}
?>
