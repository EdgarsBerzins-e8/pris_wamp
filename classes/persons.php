<?php

class Persons extends Database
{
  protected $var, $data = [];

  // get all fields of all persons from persons table ordered by first name
  public function getAllPersons()
  {
    return $this->get('persons', null, 'name');
  }

  // get all fields of one person by id
  public function getPerson($var)
  {
    return $this->get('persons', $var);
  }

  // add new person
  public function addPerson($data)
  {
    return $this->add('persons', $data);
  }

  // update person by id
  public function updatePerson($data)
  // id should be in $data['id']
  {
    return $this->set('persons', $data);
  }
}
?>