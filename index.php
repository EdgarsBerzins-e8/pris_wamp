<?php

require_once 'classes/classes.php';

$persons = new Persons();
$devices = new Devices();
$systems = new Systems();

// add new person or edit existing person
if(isset($_POST['submitPersonNew']) || isset($_POST['submitPersonEdit']))
{
  $_INPUT = $s->san($_POST);
  $data['name'] = $_INPUT['name'];
  $data['surname'] = $_INPUT['surname'];
  $data['phone'] = $_INPUT['phone'];
  $data['location'] = $_INPUT['location'];
  $data['room'] = $_INPUT['room'];
  if(isset($_POST['submitPersonEdit'])) 
  {
    $data['id'] = $_INPUT['id'];
    $persons->updatePerson($data);
  }
  else 
  {
    $persons->addPerson($data);
  }
}
// add new device or edit existing device
elseif(isset($_POST['submitDeviceNew']) || isset($_POST['submitDeviceEdit']))
{
  $_INPUT = $s->san($_POST);
  $data['device'] = $_INPUT['device'];
  $data['model'] = $_INPUT['model'];
  if(isset($_POST['submitDeviceEdit'])) 
  {
    $data['id'] = $_INPUT['id'];
    $devices->updateDevice($data);
  }
  else 
  {
    $devices->addDevice($data);
  }
}
// add new system or edit existing system
elseif(isset($_POST['submitSystemNew']) || isset($_POST['submitSystemEdit']))
{
  $_INPUT = $s->san($_POST);
  $data['name'] = $_INPUT['name'];
    if(isset($_POST['submitSystemEdit'])) 
  {
    $data['id'] = $_INPUT['id'];
    $systems->updateSystem($data);
  }
  else 
  {
    $systems->addSystem($data);
  }
}

$load_page = 'persons_page.php';
if(isset($_GET['page'])) {
  switch($_GET['page'])
  {
    case "devices": $load_page = 'devices_page.php'; break;
    case "systems": $load_page = 'systems_page.php'; break;
  }
}

require_once 'page_header.php';
require_once $load_page;
require_once 'page_footer.php';
?>
