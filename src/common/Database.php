<?php

require './common/Config.php';
require './common/JoinQueries.php';

class Database
{
  use JoinQueries;

  private static $_database;
  private static $_pdo;

  private $_rowCount;
  private $_results;

  private function __construct()
  {
    $host = Config::get("database.host");
    $name = Config::get("database.name");
    $user = Config::get("database.user");
    $password = Config::get("database.password");
    $port = Config::get("database.port");
    $charset = Config::get("database.charset");

    try {
      $dsn = "mysql:host={$host};port={$port};dbname={$name};charset={$charset}";
      $this->_pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
      ]);
    } catch (PDOException $e) {
      Helpers::error($e->getMessage());
    }
  }

  public static function getInstance()
  {
    if (!isset(self::$_database)) {
      self::$_database = new Database();
    }

    return (self::$_database);
  }

  public function query($query, $data = [])
  {
    $this->_rowCount = 0;
    $this->_results = [];

    // Catch any error from prepare() or execute()
    try {
      $statement = $this->_pdo->prepare($query);

      foreach ($data as $key => $value) {
        $statement->bindValue($key, $value);
      }

      if ($statement->execute()) {
        $this->_results = $statement->fetchAll();
        $this->_rowCount = $statement->rowCount();
      }
    } catch (PDOException $e) {
      Helpers::error("{$e->getMessage()} in {$e->getFile()} on line {$e->getLine()}");
    }

    return $this;
  }

  public function select($table, $where = [], $columns = [])
  {
    if (empty($columns)) {
      $columns = "*";
    } else {
      $columns = implode(", ", $columns);
    }

    if (count($where) === 3) {
      $operator = $where[1];
      $operators = ["=", ">", "<", ">=", "<="];

      if (in_array($operator, $operators)) {
        $field = $where[0];
        $data = [":value" => $where[2]];

        return $this->query("SELECT $columns FROM {$table} WHERE {$field} {$operator} :value", $data)->results();
      }
    }

    return $this->query("SELECT $columns FROM $table")->results();
  }

  public function insert($table, $data)
  {
    $values = [];
    foreach ($data as $key => $value) {
      array_push($values, ":{$key}");
    }

    $columns = implode(", ", array_keys($data));
    $values = implode(", ", array_values($values));

    $this->query("INSERT INTO $table ($columns) VALUES ($values)", $data);

    return $this->_pdo->lastInsertId();
  }

  public function update($table, $id, $data)
  {
    $set = [];
    foreach ($data as $key => $value) {
      array_push($set, "$key=:$key");
    }
    $set = implode(", ", $set);

    $this->query("UPDATE $table SET $set WHERE id=$id", $data);

    return !!$this->rowCount();
  }

  public function delete($table, $where)
  {
    if (count($where) === 3) {
      $operator = $where[1];
      $operators = ["=", ">", "<", ">=", "<="];

      if (in_array($operator, $operators)) {
        $field = $where[0];
        $data = [":value" => $where[2]];
        $this->query("DELETE FROM {$table} WHERE {$field} {$operator} :value", $data);
      }
    }

    return !!$this->rowCount();
  }

  public function rowCount()
  {
    return $this->_rowCount;
  }

  public function results()
  {
    return $this->_results;
  }
}
