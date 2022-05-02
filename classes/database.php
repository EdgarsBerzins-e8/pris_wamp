<?php
class Con
{

  protected static $_instance;
  protected $_connection;
  protected $_dns = 'mysql:host=localhost;dbname=pris';
  protected $_username = 'root';
  protected $_password = '';
  protected $_opt = array(
      // any occurring errors wil be thrown as PDOException
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      // an SQL command to execute when connecting
      PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'",
      PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET 'UTF8'"
  );

  /**
  * Singleton pattern implementation makes "new" unavailable
  */
  protected function __construct() {
    try {
      $this->_connection = new PDO($this->_dns, $this->_username, $this->_password, $this->_opt);
    } catch (Exception $e) {
      die('Sistēmas kļūda. Neizdevās pieslēgties datubāzei. Pēc brīža lūdzu mēģiniet vēlreiz.');
    }
  }

  public function db() {
    return $this->_connection;
  }

  public static function getInstance() {
    if (null === self::$_instance) {
      self::$_instance = new self();
    }
    return self::$_instance;
  }

  /**
  * Singleton pattern implementation makes "clone" unavailable
  */
  protected function __clone() {}
  
  public function lastInsertId() {
    return $this->_connection->lastInsertId();
  }
}

class Database
{

  protected $query, $data;

  public function add($table, $data, $ignoreRegistered = true) {
    if(empty($table)) throw new Exception('Nav norādīta tabula', 991);
    if(!is_array($data)) throw new Exception('Saņemtie dati nav masīvs', 992);
    
    // ja datu masīvs ir tukšs, tad jaunu ierakstu nereģistrē
    if(empty($data)) return;
    
    if(isset($data['id'])) unset($data['id']);

    // pārbauda vai šāds ieraksts jau ir reģistrēts
    // ja ir reģistrēts, tad atgriež viņa ID
    if($ignoreRegistered) {
      if($res = $this->check($table, $data)) return $res;
    }
    
    // sāk gatavot query
    $query = "INSERT `".$table."` SET";
    
    // pirms pirmā mainīgā query nevajag komatu
    $first = true;
    $keys = array_keys($data);
    foreach($keys as $key) {
      // ja nav pirmais mainīgais, tad pieliek komatu
      if(!$first) $query .= ',';
      // pirmais mainīgais ir garām un pārējiem būs jāliek priekšā komats
      $first = false;
      $query .= " `".$key."` = :".$key;
    }
    $res = Con::getInstance()->db()->prepare($query);
    $res->execute($data);
    // atgriež ievietotās rindas ID
    return Con::getInstance()->db()->lastInsertId();
  }

  public function addDetail($table, $data, $id, $ignoreRegistered = true) {
    if(empty($table)) throw new Exception('Nav norādīta tabula', 991);
    if(!is_array($data)) throw new Exception('Saņemtie dati nav masīvs', 992);
    if(empty($id)) throw new Exception('Nav norādīts parent dokuments', 993);
    
    // ja datu masīvs ir tukšs, tad jaunu ierakstu nereģistrē
    if(empty($data)) return;
    
    if(isset($data['id'])) unset($data['id']);
    
    $data['parent_id'] = $id;
    
    // pārbauda vai šāds ieraksts jau ir reģistrēts
    // ja ir reģistrēts, tad atgriež viņa ID
    $ret = $this->check($table, $data);
    if($ret && $ignoreRegistered) return $ret;

    // sāk gatavot query
    $query = "INSERT `".$table."` SET";
    
    // pirms pirmā mainīgā query nevajag komatu
    $first = true;
    $keys = array_keys($data);
    foreach($keys as $key) {
      // ja nav pirmais mainīgais, tad pieliek komatu
      if(!$first) $query .= ',';
      // pirmais mainīgais ir garām un pārējiem būs jāliek priekšā komats
      $first = false;
      $query .= " `".$key."` = :".$key;
    }
    $res = Con::getInstance()->db()->prepare($query);
    $res->execute($data);
    // atgriež ievietotās rindas ID
    return Con::getInstance()->db()->lastInsertId();
  }

  public function check($table, $data, $id = null) {
    // ja ir padots ID, tad meklē neiekļaujot ID vērtību
    // atgriež atrasto ID vērtību vai false, ja neatrod
    if(empty($table)) throw new Exception('Nav norādīta tabula', 991);
    if(!is_array($data)) throw new Exception('Saņemtie dati nav masīvs', 992);

    // sāk gatavot query
    $query = "SELECT `id` FROM `".$table."` WHERE";
    
    // pirms pirmā mainīgā query nevajag komatu
    $first = true;
    $keys = array_keys($data);
    foreach($keys as $key) {
      // ja nav pirmais mainīgais, tad pieliek komatu
      if(!$first) $query .= ' AND';
      // pirmais mainīgais ir garām un pārējiem būs jāliek priekšā komats
      $first = false;
      $query .= " `".$key."` = :".$key;
    }
    if(!is_null($id)) {
      $data['id'] = $id;
      $query .= ' AND `id` != :id';
    }
    $res = Con::getInstance()->db()->prepare($query);
    $res->execute($data);
    if($res->rowCount() > 0) return $res->fetchObject()->id;
    else return false;
  }

  public function set($table, $data, $id = null) {
    // veic ieraksta update tabulai
    if(empty($table)) throw new Exception('Nav norādīta tabula', 991);
    if(empty($id) && isset($data['id'])) $id = $data['id'];
    if(empty($id)) throw new Exception('Nav norādīts ID', 994);
    if(!is_array($data)) throw new Exception('Saņemtie dati nav masīvs', 992);
    
    // noņem padoto $data['id'], ja tāds ir
    if(isset($data['id'])) unset($data['id']);
    
    // sāk gatavot query
    $query = "UPDATE `".$table."` SET";
    
    // pirms pirmā mainīgā query nevajag komatu
    $first = true;
    $keys = array_keys($data);

    foreach($keys as $key) {
      // ja nav pirmais mainīgais, tad pieliek komatu
      if(!$first) $query .= ',';
      // pirmais mainīgais ir garām un pārējiem būs jāliek priekšā komats
      $first = false;
      $query .= " `".$key."` = :".$key;
      // noņemt tukšumus masīva vērtībām
      if(!empty($data[$key])) $data[$key] = trim($data[$key]);
    }
    $query .= " WHERE `id` = :update_id";
    // ieraksta updeitojamo ID
    $data['update_id'] = $id;
    $res = Con::getInstance()->db()->prepare($query);
    $res->execute($data);
    return true;
  }
  
  public function setDetails($table, $data, $id = null) {
    // veic ieraksta update tabulai, kurai nav owner_id
    if(empty($table)) throw new Exception('Nav norādīta tabula', 991);
    if(empty($id) && isset($data['id'])) $id = $data['id'];
    if(empty($id)) throw new Exception('Nav norādīts ID', 994);
    if(!is_array($data)) throw new Exception('Saņemtie dati nav masīvs', 992);
    
    // ja datu masīvs ir tukšs, tad jaunu ierakstu nereģistrē
    if(empty($data)) return;

    // noņem padoto $data['id'], ja tāds ir
    if(isset($data['id'])) unset($data['id']);
    
    // sāk gatavot query
    $query = "UPDATE `".$table."` SET";
    
    // pirms pirmā mainīgā query nevajag komatu
    $first = true;
    $keys = array_keys($data);
    foreach($keys as $key) {
      // ja nav pirmais mainīgais, tad pieliek komatu
      if(!$first) $query .= ',';
      // pirmais mainīgais ir garām un pārējiem būs jāliek priekšā komats
      $first = false;
      $query .= " `".$key."` = :".$key;
      // noņemt tukšumus masīva vērtībām
      if(!empty($data[$key])) $data[$key] = trim($data[$key]);
    }
    $query .= " WHERE `id` = :update_id";

    // ieraksta updeitojamo ID
    $data['update_id'] = $id;

    $res = Con::getInstance()->db()->prepare($query);
    $res->execute($data);
    return true;
  }

  public function get($table, $id = null, $orderby = 'id') {
    // ja ir padots id, tad vienmēr atgriež caur fetchObject
    // ja id nav padots, tad atgriež $res
    if(empty($table)) throw new Exception('Nav norādīta tabula', 991);
    if(is_null($id)) {
      $res = Con::getInstance()->db()->query("SELECT * FROM `".$table."` ORDER BY `".$orderby."`");
      return $res;
    } else {
      $res = Con::getInstance()->db()->prepare("SELECT * FROM `".$table."` WHERE `id` = ?");
      $res->execute(array($id));
      return $res->fetchObject();
    }
  }

  public function getDetails($table, $parentId, $orderby = 'id') {
		if(empty($table)) throw new Exception('Nav norādīta tabula', 991);
		if(empty($parentId)) throw new Exception('Nav norādīts ID', 994);
    $res = Con::getInstance()->db()->prepare('SELECT * FROM `'.$table.'` WHERE `parent_id` = ? ORDER BY `'.$orderby.'`');
    $res->execute(array($parentId));
    return $res;
  }
  
  public function getDetail($table, $id) {
		if(empty($table)) throw new Exception('Nav norādīta tabula', 991);
		if(empty($id)) throw new Exception('Nav norādīts ID', 994);
    $res = Con::getInstance()->db()->prepare('SELECT * FROM `'.$table.'` WHERE `id` = ?');
    $res->execute(array($id));
    return $res->fetchObject();
  }
  
  public function delete($table, $id, $soft = false) {
    if(empty($table)) throw new Exception('Nav norādīta tabula', 991);
		if(empty($id)) throw new Exception('Nav norādīts ID', 994);
    if(is_null($id)) {
    } else {
      if($soft) {
        $data['del'] = $_SESSION['usr'];
        $data['id'] = $id;
        $data['at'] = date('Y-m-d H:i:s');
        $query = "UPDATE `".$table."` SET `deleted` = 1, `deleted_at` = :at, `deleted_by` = :del WHERE `id` = :id";
      }
      else {
        $data['id'] = $id;
        $query = "DELETE FROM `".$table."` WHERE `id` = :id";
      }
      $res = Con::getInstance()->db()->prepare($query);
      $res->execute($data);
    }
    return true;
  }
  
  protected function deleteDetail($table, $id, $soft = false) {
		if(empty($table)) throw new Exception('Nav norādīta tabula', 991);
		if(empty($id)) throw new Exception('Nav norādīts ID', 994);
    $res = Con::getInstance()->db()->prepare('DELETE FROM `'.$table.'` WHERE `id` = ?');
    $res->execute(array($id));
  }

  protected function runQuery() {
    $res = Con::getInstance()->db()->prepare($this->query);
    $res->execute($this->data);
    // iztukšo query un data masīvu sagatavojot nākamajam pieprasījumam
    unset($this->data, $this->query);
    return $res;
  }
}
?>