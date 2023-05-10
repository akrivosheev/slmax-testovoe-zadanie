<?php

class Person {

  private $id;
  private $name;
  private $surname;
  private $birthdate;
  private $gender;
  private $city;
  private $pdo;

  public function __construct
  ($pdo, $id = null, $name = null, $surname = null, $birthdate = null, $gender = null, $city = null)
  {
    $this->pdo = $pdo;

    $this->id = $id;
    $this->name = $name;
    $this->surname = $surname;
    $this->birthdate = $birthdate;
    $this->gender = $gender;
    $this->city = $city;

    if ($id !== null) {
      // Load person from database
      $stmt = $this->pdo->prepare('SELECT * FROM people WHERE id = ?');
      $stmt->execute([$id]);

      if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $this->name = $row['name'];
        $this->surname = $row['surname'];
        $this->birthdate = $row['birthdate'];
        $this->gender = $row['gender'];
        $this->city = $row['city'];

        if (!$this->isValid()) {
          throw new Exception('Invalid data retrieved from database');
        }
      } else {
        throw new Exception('Person not found in database');
      }
    } else {
      // Create new person in database
      $this->save();
    }
  }

  public function getId() {
    return $this->id;
  }

  public function getName() {
    return $this->name;
  }

  public function getSurname() {
    return $this->surname;
  }

  public function getBirthdate() {
    return $this->birthdate;
  }

  public function getGender() {
    return $this->gender;
  }

  public function getCity() {
    return $this->city;
  }

  public function setName($name) {
    $this->name = $name;
  }

  public function setSurname($surname) {
    $this->surname = $surname;
  }

  public function setBirthdate($birthdate) {
    $this->birthdate = $birthdate;
  }

  public function setGender($gender) {
    $this->gender = $gender;
  }

  public function setCity($city) {
    $this->city = $city;
  }

  public function save() {
    if (!$this->isValid()) {
      throw new Exception('Invalid data');
    }

    if ($this->id !== null) {
      // Update existing person
      $stmt = $this->pdo->prepare('UPDATE people SET name = ?, surname = ?, birthdate = ?, gender = ?, city = ? WHERE id = ?');
      $stmt->execute([$this->name, $this->surname, $this->birthdate, $this->gender, $this->city, $this->id]);
    } else {
      // Insert new person
      $stmt = $this->pdo->prepare('INSERT INTO people (name, surname, birthdate, gender, city) VALUES (?, ?, ?, ?, ?)');
      $stmt->execute([$this->name, $this->surname, $this->birthdate, $this->gender, $this->city]);
      $this->id = $this->pdo->lastInsertId();
    }
  }

  public function delete() {
    if ($this->id !== null) {
      $stmt = $this->pdo->prepare('DELETE FROM people WHERE id = ?');
      $stmt->execute([$this->id]);
      $this->id = null;
    }
  }

  public static function ageFromDate($birthdate) {

    $tz  = new DateTimeZone('Europe/Minsk');

    $age = DateTime::createFromFormat('Y-m-d', $birthdate, $tz)
      ->diff(new DateTime('now', $tz))
      ->y;

    return $age;
  }

  public static function genderFromBinary($gender) {
    return $gender == 0 ? 'male' : 'female';
  }

  public function format($age = false, $gender = false) {
    $person = new stdClass();
    $person->id = $this->id;
    $person->name = $this->name;
    $person->surname = $this->surname;
    $person->birthdate = $this->birthdate;
    $person->gender = $this->gender;
    $person->city = $this->city;

    if ($age) {
      $person->age = self::ageFromDate($this->birthdate);
    }

    if ($gender) {
      $person->gender = self::genderFromBinary($this->gender);
    }

    return $person;
  }

  private function isValid() {

    $tz  = new DateTimeZone('Europe/Minsk');

    return preg_match('/^([а-яА-ЯЁёa-zA-Z0-9_ ]+)$/u', $this->name)
      && preg_match('/^([а-яА-ЯЁёa-zA-Z0-9_ ]+)$/u', $this->surname)
      && DateTime::createFromFormat('Y-m-d', $this->birthdate, $tz) !== false
      && ($this->gender == 0 || $this->gender == 1)
      && preg_match('/^([а-яА-ЯЁёa-zA-Z0-9_ ]+)$/u', $this->city);
  }

}
