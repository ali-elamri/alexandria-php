<?php

require "./core/Model.php";

class User extends Model
{
  protected $table = "users";
  protected $fillable = ["firstname", "lastname", "email", "password"];
  protected $relationships = [
    [
      'object' => 'role',
      'table' => 'roles',
      'columns' => ["name"]
    ]
  ];

  public static function findByEmail($email)
  {
    return static::findFirst(["email", "=", $email]);
  }
}
