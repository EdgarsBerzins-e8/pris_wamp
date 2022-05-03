<?php
class Devices extends Database
{
  protected $var, $data = [];
  
   // get all fields of all devices from devices table ordered by device name
   public function getAllDevices()
  {
    return $this->get('devices', null, 'device');
  }

  // get all fields of one device by id
  public function getDevice($var)
  {
    return $this->get('devices', $var);
  }

  // add new device
  public function addDevice($data)
  {
    return $this->add('devices', $data);
  }

  // update person by id
  public function updateDevice($data)
    // id should be in $data['id']
  {
    return $this->set('devices', $data);
  }}
?>