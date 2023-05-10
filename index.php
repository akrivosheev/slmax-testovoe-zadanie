<?php

require_once('Person.php');
require_once('PersonList.php');

// Connect to the database using PDO
$dsn = 'mysql:host=mysql;dbname=tcw;charset=utf8';
$username = 'root';
$password = 'pass';
$options = [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  PDO::ATTR_EMULATE_PREPARES => false
];

try {
  $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
  die('Connection failed: ' . $e->getMessage());
}

// Check

// Create new person and save to database
//$person = new Person(null, 'Алиса', 'Двачевская', '1972-01-01', 1, 'Смоленск');

// Load person from database and update
//$person = new Person($pdo, 10);
//$person->setCity('Las Angeles');
//$person->save();

// Load person from database and delete
//$person = new Person($pdo,4);
//$person->delete();

$age = Person::ageFromDate('1971-05-05');
$gender = Person::genderFromBinary(1);

$conditions = [
//  'id' => ['2', '>'],
//  'name' => 'Алиса',
//  'surname' => 'Двачевская',
//  'city' => 'New York',
//  'birthdate' => ['1990-01-01', '>'],
//  'gender' => 1,
];

$personlist = new PersonList($pdo, $conditions);
$list = $personlist->getPeople();
//$personlist->deletePeople();

