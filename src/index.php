<?php

require_once "./constants.php";
require_once "./common/Helpers.php";
require_once "./common/Database.php";

echo "Welcome to " . APP_NAME . "!";
echo "<br>";
echo "<br>";

$db = Database::getInstance();

$usersRelationships = [
  [
    'object' => 'role',
    'table' => 'roles',
    'columns' => ["name"]
  ]
];


$booksRelationships = [
  [
    'object' => 'author',
    'table' => 'authors',
    'columns' => ["firstname", "lastname", "birthdate", "country"]
  ],
  [
    'object' => 'category',
    'table' => 'categories',
    'columns' => ["name"]
  ]
];




function nestRelationships($data, $relationships)
{
  foreach ($data as $d) {
    foreach ($relationships as $relationship) {

      $object = $relationship["object"];
      $table = $relationship["table"];
      $columns = $relationship["columns"];
      $foreignKey = $object . "_id";

      $d->$object = new stdClass();

      foreach ($columns as $column) {
        $value = $table . "_" . $column;
        $d->$object->$column = $d->$value;
        unset($d->$value);
      }
      unset($d->$foreignKey);
    }
  }

  return $data;
}


$books = $db->selectJoin('books', $booksRelationships);
$users = $db->selectJoin('users', $usersRelationships);

$books = nestRelationships($books, $booksRelationships);
$users = nestRelationships($users, $usersRelationships);


echo "<pre>";
print_r($books);
print_r($users);
print_r($db->select('users'));
echo "</pre>";
