<?php

require "./core/Model.php";

class Book extends Model
{
  protected $table = "books";
  protected $fillable = ["title", "editor", "published_on", "price", "cover"];
  protected $relationships = [
    [
      'object' => 'author',
      'table' => 'authors',
      'columns' => ["firstname", "lastname", "birthdate", "country"]
    ],
    [
      'object' => 'category',
      'table' => 'categories',
      'columns' => ["name"]
    ],
  ];

  public static function findByEmail($email)
  {
    return static::findFirst(["email", "=", $email]);
  }
}
