<?php
class Systems extends Database
{
  protected $var, $data = [];

  public function getAllSystems()
  {
    return $this->get('systems', null, 'name');
  }

  public function getSystem($var)
  {
    return $this->get('systems', $var);
  }

  public function addSystem($data)
  {
    return $this->add('systems', $data);
  }

  public function updateSystem($data)
  {
    return $this->set('systems', $data);
  }}
?>