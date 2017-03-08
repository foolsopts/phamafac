<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['nav_menu'] = array(
	array(
		"page" => "welcome",
		"name" => '<i class="fa fa-home"></i> Employee Viewer',
		"url" => base_url().'welcome.html',
		"auth_class" => array(
      "all"
    )
	),
	// array(
	// 	"page" => "message",
	// 	"name" => '<i class="fa fa-envelope"></i>Message',
	// 	"url" => '#',
	// 	"auth_class" => array(
  //     "Thevirus",
	// 		"all"
  //   )
	// ),
	// array(
	// 	"page" => "warehouse",
	// 	"name" => '<i class="fa fa-cubes" aria-hidden="true"></i> คลัง',
	// 	"url" => '#',
	// 	"auth_class" => array(
  //     "Thevirus"
  //   ),
	// 	"child" => array(
	// 		array(
	// 			"page" => "",
	// 			"name" => '<i class="fa fa-wrench" aria-hidden="true"></i> แก้ไข / ปรับปรุง คลัง',
	// 			"url" => base_url().'warehouse.html'
	// 		)
	// 	)
	// ),
	// array(
	// 	"page" => "kpi",
	// 	"name" => '<i class="fa fa-balance-scale" aria-hidden="true"></i> จัดการ KPI',
	// 	"url" => '#',
	// 	"auth_class" => array(
  //     "Thevirus",
	// 		"Admin"
  //   ),
	// 	"child" => array(
	// 		array(
	// 			"page" => "",
	// 			"name" => '<i class="fa fa-plus-square" aria-hidden="true"></i> เพิ่ม KPI ใหม่',
	// 			"url" => base_url().'kpi.html'
	// 		)
	// 	)
	// ),
	// array(
	// 	"page" => "voucher",
	// 	"name" => '<i class="fa fa-star" aria-hidden="true"></i> สวัสดิการ / ของสมนาคุณ',
	// 	"url" => '#',
	// 	"auth_class" => array(
  //     "Thevirus",
	// 		"all"
  //   ),
	// 	"child" => array(
	// 		array(
	// 			"page" => "",
	// 			"name" => '<i class="fa fa-wrench" aria-hidden="true"></i> ตั้งค่า รายการ',
	// 			"url" => base_url().'voucher.html'
	// 		)
	// 	)
	// )
);
