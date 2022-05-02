<?php
class Sanitarize {
  public function san($input) {
    if(is_object($input)) $input = get_object_vars($input);
    if(is_array($input)) {
      foreach($input as $var => $val) {
        $output[$var] = $this->san($val);
      }
    } else {
      $output = trim(htmlspecialchars(strip_tags($input), ENT_QUOTES, 'UTF-8'));
    }
    return $output;
  }
}
?>