<?php
require_once 'database.php';
require_once 'sanitarize.php';
require_once 'persons.php';
require_once 'devices.php';
require_once 'systems.php';

$u = new Utility;
$s = new Sanitarize;

class Utility {

  public function getRandomString($length = 50) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    for ($p = 0; $p < $length; $p++) {
      $string .= $characters[mt_rand(0, strlen($characters))];
    }
    return $string;
  }

  public function validDate($var) {
    $date = date_parse($var);
    return checkdate($date['month'], $date['day'], $date['year']) && $date['error_count'] == 0 ? true : false;
  }
  
  public function validEmail($var) {
    return filter_var($var, FILTER_VALIDATE_EMAIL);
  }

  public function pa($input) {
    echo '<pre>';
    var_dump($input);
    echo '</pre>';
  }

  public function query($arr, $query, $replace = false) {
		$query = str_replace(':', '@', $query);
		echo '----------------<br>';
		foreach($arr as $key => $val) {
      if($replace) $query = str_replace('@'.$key, "'$val'", $query);
			else echo 'set @'.$key.'="'.$val.'";<br>';
		}
		echo $query.'<br>----------------<br>';
  }
  
  public static function xtrim($text) {
    return trim(strtr($text, array_flip(get_html_translation_table(HTML_ENTITIES, ENT_QUOTES))),chr(0xC2).chr(0xA0));
  }

  public function trimArray($data) {
    if(empty($data)) return false;
    foreach ($data as $key => $value) {
      if(is_array($value)) $u->trimArray($value);
      else {
				if(empty($value) || $value === false) unset($data[$key]);
				else {
					$value = trim($value);
					if(empty($value) || $value === false) unset($data[$key]);
					else $data[$key] = $value;
				}
      }
    }
    if(empty($data)) return false;
    return $data;
  }
}
?>