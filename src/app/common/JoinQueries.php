<?php

trait JoinQueries
{
  private function parseJoin($table, $relationships)
  {
    $joins = [];
    $columns = ["$table.*"];

    foreach ($relationships as $relationship) {
      $joinTable = $relationship["table"];
      $foreignKey = $relationship['object'] . "_id";

      $joins[$joinTable] = $foreignKey;

      foreach ($relationship['columns'] as $column) {
        array_push($columns, $joinTable . "." . $column);
      }
    }

    return ['joins' => $joins, "columns" => $columns];
  }

  public function selectJoin($table, $relationships, $where = [])
  {

    $parse = $this->parseJoin($table, $relationships);
    $columns = $parse['columns'];
    $joins = $parse['joins'];

    if (empty($columns)) {
      $columns = "*";
    } else {
      array_walk($columns, function (&$value) use ($table) {
        $explode = explode(".", $value);
        if ($explode[0] !== $table) {
          $value = "$value as $explode[0]_$explode[1]";
        }
      });

      $columns = implode(", ", $columns);
    }

    $joinStatement = "";
    foreach ($joins as $joinTable => $foreignKey) {
      $joinStatement .= "JOIN $joinTable ON $table.$foreignKey = $joinTable.id ";
    }

    if (count($where) === 3) {
      $operator = $where[1];
      $operators = ["=", ">", "<", ">=", "<="];

      if (in_array($operator, $operators)) {
        $field = $where[0];
        $data = [":value" => $where[2]];

        return $this->query("SELECT $columns FROM {$table} $joinStatement WHERE {$field} {$operator} :value", $data, true);
      }
    }

    return $this->query("SELECT $columns FROM $table $joinStatement", [], true);
  }
}
