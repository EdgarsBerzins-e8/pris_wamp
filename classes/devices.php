<?php
class Devices extends Database
{
  protected $var, $data = [];
  
  public function getAllDevices()
  {
    return $this->get('devices', null, 'device');
  }

  public function getDevice($var)
  {
    return $this->get('devices', $var);
  }

  public function addDevice($data)
  {
    return $this->add('devices', $data);
  }

  public function updateDevice($data)
  {
    return $this->set('devices', $data);
  }}
?>