<?php

function friendly($string)
  {
    return preg_replace(array(
      "`[^a-z0-9ก-๙เ-า]`i",
      "`[-]+`"
    ), "_", $string);
  }

  function RandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
  }
  function removeJava($html)
  {
		return preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $html);
	}

  function json_stat($stat, $array)
  {
      $json = array(
        "stat" => $stat,
        "data" => $array
      );
      return json_encode($json);
  }
  function getter_param($default, $param = array(), $type = "std")
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
  function whiteSpace($img)
  {
    $original = $img;
    $width = 300;
    $height = 200;
    $do = FALSE;
    //load the image
    $image_info = getImageSize($img);
    switch ($image_info['mime']) {
    case 'image/gif':
        $img = imagecreatefromgif($img);
        break;
    case 'image/jpeg':
        $img = imagecreatefromjpeg($img);
        break;
    case 'image/png':
        $img = imagecreatefrompng ($img);
        break;
    default:
        // handle errors
        break;
    }
    if(imagecolorat($img, $width, $height) === 0xFFFFFF) {
        $do = TRUE;
    }else{
      $do = FALSE;
    }
    if(imagecolorat($img,imagesx($img)-$width, imagesy($img)-$height) === 0xFFFFFF){
      $do = TRUE;
    }else{
      $do = FALSE;
    }

    if($do === TRUE){
	   require_once( APPPATH.'/third_party/Nomalize.php' );
     $im = new ImageManipulator($original);
     $centreX = round($im->getWidth() / 2);
     $centreY = round($im->getHeight() / 2);
     $x1 = $centreX - $width/2;
     $y1 = $centreY - $height/2;
     $x2 = $centreX + $width/2;
     $y2 = $centreY + $height/2;
     return $im->crop($x1, $y1, $x2, $y2); // takes care of out of boundary conditions automatically
   }else{
     return $original;
   }
  }
  function isAjax($bypass=NULL)
	{
		if($bypass !== 24680){
			define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
			if (!IS_AJAX) {
				return false;
			}
			$pos = strpos($_SERVER['HTTP_REFERER'], getenv('HTTP_HOST'));
			if ($pos === false)
				return false;
		}
    return true;
	}
  function push_file($fname,$fpath,$content)
  {
    try{
      if(!is_dir($fpath)){
          @mkdir($fpath, 0777, true);
      }
      $fp = fopen($fpath.$fname,"wb");
      fwrite($fp,$content);
      fclose($fp);
    }catch(Exception $e){
      return false;
    }
    return $fname;
  }
  /**
* Compute the start and end date of some fixed o relative quarter in a specific year.
* @param mixed $quarter  Integer from 1 to 4 or relative string value:
*                        'this', 'current', 'previous', 'first' or 'last'.
*                        'this' is equivalent to 'current'. Any other value
*                        will be ignored and instead current quarter will be used.
*                        Default value 'current'. Particulary, 'previous' value
*                        only make sense with current year so if you use it with
*                        other year like: get_dates_of_quarter('previous', 1990)
*                        the year will be ignored and instead the current year
*                        will be used.
* @param int $year       Year of the quarter. Any wrong value will be ignored and
*                        instead the current year will be used.
*                        Default value null (current year).
* @param string $format  String to format returned dates
* @return array          Array with two elements (keys): start and end date.
*/
function get_dates_of_quarter($quarter = 'current', $year = null, $format = null)
{
    if($year !== null){
      $year = (int)$year;
    }
    if ( !is_int($year) ) {
       $year = (new DateTime)->format('Y');
    }
    $current_quarter = ceil((new DateTime)->format('n') / 3);
    switch (  strtolower($quarter) ) {
    case 'this':
    case 'current':
       $quarter = ceil((new DateTime)->format('n') / 3);
       break;

    case 'previous':
       $year = (new DateTime)->format('Y');
       if ($current_quarter == 1) {
          $quarter = 4;
          $year--;
        } else {
          $quarter =  $current_quarter - 1;
        }
        break;

    case 'first':
        $quarter = 1;
        break;
    case 'secound':
      $quarter = 2;
      break;
    case 'thirth':
      $quarter = 3;
      break;
    case 'last':
        $quarter = 4;
        break;

    default:
        $quarter = (!is_int($quarter) || $quarter < 1 || $quarter > 4) ? $current_quarter : $quarter;
        break;
    }
    if ( $quarter === 'this' ) {
        $quarter = ceil((new DateTime)->format('n') / 3);
    }
    $start = new DateTime($year.'-'.(3*$quarter-2).'-1 00:00:00');
    $end = new DateTime($year.'-'.(3*$quarter).'-'.($quarter == 1 || $quarter == 4 ? 31 : 30) .' 23:59:59');

    return array(
        'start' => $format ? $start->format($format) : $start,
        'end' => $format ? $end->format($format) : $end,
    );
}
  /**
 * Lorem Ipsum Generator
 *
 * @param   integer Number of paragraphs to generate
 * @param   size of text in paras - short, medium, large
 * @param   options array - see readme
 * @return  html with Lorem Ipsum text
 */
if (!function_exists('lipsum')) {
    function lipsum($what = 'bytes', $size=50, $options= array())
    {
      $CI =& get_instance();
      $CI->load->library('simple_html_dom'); // load library
      $postdata = http_build_query(
        array(
          'amount'=>$size,
          'what'=>$what,
          'generate'=>'%CA%C3%E9%D2%A7+Lorem+Ipsum'
        )
      );

      $opts = array('http' =>
        array(
            'method'  => 'POST',
            'header'  => 'Content-type: application/x-www-form-urlencoded',
            'content' => $postdata
        )
      );
      $context  = stream_context_create($opts);
      $raw = file_get_html('http://th.lipsum.com/feed/html', false, $context);
      return $raw->find('divlipsum')[0]->plaintext;
    }
}
if ( ! function_exists('makeDir'))
{
	function makeDir($dir, $per = 0777)
	{
		if (!is_dir($dir)) {
			$oldumask = umask(0);
			mkdir($dir, $per); // or even 01777 so you get the sticky bit set
			umask($oldumask);
		}
	}
}
if (!function_exists('array_order_by')) {
    function array_order_by()
    {
        $args = func_get_args();
        $data = array_shift($args);
        foreach ($args as $n => $field) {
            if (is_string($field)) {
                $tmp[$field] = array();
                foreach ($data as $key => $row)
                    $tmp[$field][$key] = $row[$field];
                $args[$n] = &$tmp[$field];
            } else {
                $args[$n] = &$args[$n];
            }
        }
        $args[] = &$data;
        call_user_func_array('array_multisort', $args);
        return array_pop($args);
    }
}
function objectToArray($d) {
        if (is_object($d)) {
            // Gets the properties of the given object
            // with get_object_vars function
            $d = get_object_vars($d);
        }

        if (is_array($d)) {
            /*
            * Return array converted to object
            * Using __FUNCTION__ (Magic constant)
            * for recursive call
            */
            return array_map(__FUNCTION__, $d);
        }
        else {
            // Return array
            return $d;
        }
    }
    function arrayToObject($d) {
       if (is_array($d)) {
           /*
           * Return array converted to object
           * Using __FUNCTION__ (Magic constant)
           * for recursive call
           */
           return (object) array_map(__FUNCTION__, $d);
       }
       else {
           // Return object
           return $d;
       }
   }
if ( ! function_exists('randColor'))
{
	function randColor($format = "hex")
	{
        $palette = array (
          0 => array(
             'name' => 'red_100',
             'type' => 'color',
             'text' => 'f9bdbb'
           ),
          1 => array(
             'name' => 'pink_100',
             'type' => 'color',
             'text' => 'f8bbd0'
           ),
          2 => array(
             'name' => 'purple_100',
             'type' => 'color',
             'text' => 'e1bee7'
           ),
          3 => array(
             'name' => 'deep_purple_100',
             'type' => 'color',
             'text' => 'd1c4e9'
           ),
          4 => array(
             'name' => 'indigo_100',
             'type' => 'color',
             'text' => 'c5cae9'
           ),
          5 => array(
             'name' => 'blue_100',
             'type' => 'color',
             'text' => 'd0d9ff'
           ),
          6 => array(
             'name' => 'light_blue_100',
             'type' => 'color',
             'text' => 'b3e5fc'
           ),
          7 => array(
             'name' => 'cyan_100',
             'type' => 'color',
             'text' => 'b2ebf2'
           ),
          8 => array(
             'name' => 'teal_100',
             'type' => 'color',
             'text' => 'b2dfdb'
           ),
          9 => array(
             'name' => 'green_100',
             'type' => 'color',
             'text' => 'a3e9a4'
           ),
          10 => array(
             'name' => 'light_green_100',
             'type' => 'color',
             'text' => 'dcedc8'
           ),
          11 => array(
             'name' => 'lime_100',
             'type' => 'color',
             'text' => 'f0f4c3'
           ),
          12 => array(
             'name' => 'yellow_100',
             'type' => 'color',
             'text' => 'fff9c4'
           ),
          13 => array(
             'name' => 'amber_100',
             'type' => 'color',
             'text' => 'ffecb3'
           ),
          14 => array(
             'name' => 'orange_100',
             'type' => 'color',
             'text' => 'ffe0b2'
           ),
          15 => array(
             'name' => 'deep_orange_100',
             'type' => 'color',
             'text' => 'ffccbc'
           ),
          16 => array(
             'name' => 'brown_100',
             'type' => 'color',
             'text' => 'd7ccc8'
           ),
          17 => array(
             'name' => 'grey_100',
             'type' => 'color',
             'text' => 'f5f5f5'
           ),
          18 => array(
             'name' => 'blue_grey_100',
             'type' => 'color',
             'text' => 'cfd8dc'
           )
         );
        $index = array_rand($palette,1);
        $result = $palette[$index];
        if($format === "rgb"){
          $hex = "#".$result["text"];
          list($r, $g, $b) = sscanf($hex, "#%02x%02x%02x");
          $color = "$r,$g,$b";
        }elseif($format === "hex"){
          $color = "#".$result["text"];
        }
        return $color;
	}

  

  /**
   * Search for a key in an array, returning a path to the entry.
   *
   * @param $needle
   *   A key to look for.
   * @param $haystack
   *   A keyed array.
   * @param $forbidden
   *   A list of keys to ignore.
   * @param $path
   *   The intermediate path. Internal use only.
   * @return
   *   The path to the parent of the first occurrence of the key, represented as an array where entries are consecutive keys.
   */
  function array_key_path($needle, $haystack, $forbidden = array(), $path = array()) {
    $return = FALSE;
    foreach ($haystack as $key => $val) {
      if (in_array($key, $forbidden)) {
        continue;
      }
      if (is_array($val) && is_array($sub = $this->array_key_path($needle, $val, $forbidden, array_merge($path, (array)$key)))) {
        $return = $sub;
        break;
      }
      elseif ($key === $needle) {
        $return = array_merge($path, (array)$key);
        break;
      }
    }
    return FALSE;
  }

  /**
   * Given a path, return a reference to the array entry.
   *
   * @param $array
   *   A keyed array.
   * @param $path
   *   An array path, represented as an array where entries are consecutive keys.
   * @return
   *   A reference to the entry that corresponds to the given path.
   */
  function &array_path(&$array, $path) {
    $offset =& $array;
    if ($path) foreach ($path as $index) {
      $offset =& $offset[$index];
    }
    return $offset;
  }
}
?>
