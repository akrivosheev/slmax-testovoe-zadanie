<?php

if (!class_exists('Person')) {
  echo 'Error: Class "People" not found.';
  return;
}

class PersonList
{

  private $personIds;
  private $pdo;

  public function __construct($pdo, $conditions = [])
  {
    $this->pdo = $pdo;
    $this->personIds = $this->searchPeople($conditions);
  }

  private function searchPeople($conditions)
  {

    $id = $conditions['id'];
    $name = $conditions['name'];
    $surname = $conditions['surname'];
    $birthdate = $conditions['birthdate'];
    $gender = $conditions['gender'];
    $city = $conditions['city'];

    $query = "SELECT * FROM people WHERE 1=1";
    $params = array();

    if ($id !== null) {
      $com = '=';
      if (!empty($id[1])) {
        $com = $id[1];
      }
      $query .= " AND id $com :id";
      $params['id'] = $id[0];
    }

    if ($name !== null) {
      $query .= " AND name = :name";
      $params['name'] = $name;
    }

    if ($surname !== null) {
      $query .= " AND surname = :surname";
      $params['surname'] = $surname;
    }

    if ($city !== null) {
      $query .= " AND city = :city";
      $params['city'] = $city;
    }

    if ($gender !== null) {
      $query .= " AND gender = :gender";
      $params['gender'] = $gender;
    }

    if ($birthdate !== null) {
      $com = '=';
      if (!empty($birthdate[1])) {
        $com = $birthdate[1];
      }
      $query .= " AND birthdate $com :birthdate";
      $params['birthdate'] = $birthdate[0];
    }

    $stmt = $this->pdo->prepare($query);
    $stmt->execute($params);

    $ids = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $ids[] = $row['id'];
    }

    return $ids;
  }

  public function getPeople()
  {
    $people = [];
    foreach ($this->personIds as $id) {
      $people[] = new Person($this->pdo, $id);
    }
    return $people;
  }

  public function deletePeople()
  {
    foreach ($this->personIds as $id) {
      $person = new Person($this->pdo, $id);
      $person->delete();
    }
  }

}
