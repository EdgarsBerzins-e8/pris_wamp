<?php

class Persons extends Database
{
  protected $var, $data = [];

  public function getAllPersons()
  {
    return $this->get('persons', null, 'name');
  }

  public function getPerson($var)
  {
    return $this->get('persons', $var);
  }

  public function addPerson($data)
  {
    return $this->add('persons', $data);
  }

  public function updatePerson($data)
  {
    return $this->set('persons', $data);
  }
}
?>