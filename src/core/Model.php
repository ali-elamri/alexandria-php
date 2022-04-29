<?php

require("./common/Database.php");

class Model
{
  private static $_model;
  protected $database = null;

  public function __construct()
  {
    $this->database = Database::getInstance();
  }

  private function getInstance()
  {
    if (empty($_model)) {
      static::$_model = new static();
    }

    return static::$_model;
  }

  private static function find($where = [])
  {
    $instance = static::getInstance();
    return $instance->database->select($instance->table, $where);
  }

  public static function findAll($where = [])
  {
    return static::find($where)->results();
  }

  public static function findFirst($where = [])
  {
    return static::find($where)->first();
  }

  public static function findByID($id)
  {
    return static::findFirst(["id", "=", $id]);
  }

  public static function create($properties)
  {
    $instance = static::getInstance();
    $id =  $instance->database->insert($instance->table, $properties);
    return static::findByID($id);
  }

  public static function update($id, $properties)
  {
    $instance = static::getInstance();
    $instance->database->update($instance->table, $id, $properties);
    return static::findByID($id);
  }

  public function save()
  {
    $data = [];
    foreach ($this->fillable as $fillable) {
      $data[$fillable] = $this->$fillable;
    }

    if (isset($this->id)) {
      $record = static::update($this->id, $data);
    } else {
      $record = static::create($data);
      $this->id = $record->id;
    }

    return $record;
  }

  public function delete()
  {
    return $this->database->delete($this->table, ["id", "=", $this->id]);
  }

  public static function findWith()
  {
    $instance = static::getInstance();
    $records = $instance->database->selectJoin($instance->table, $instance->relationships)->results();
    return static::nestRelationships($records, $instance->relationships);
  }

  private static function nestRelationships($data, $relationships)
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
}
