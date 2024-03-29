<?php

namespace App\Core;

interface QueryBuilder
{
  public function insert(array $values): QueryBuilder;

    /**
   * $operator asked:
   *
   * - `0` = NONE
   * - `1` = MAX
   */
  public function select(array $columns, string $table = "default", int $operator = 0): QueryBuilder;

  public function delete(): QueryBuilder;

  public function update(): QueryBuilder;

  public function set($column, string $operator = '='): QueryBuilder;

  public function where(string $column, string $operator = '=', ?string $table = NULL ): QueryBuilder;

  public function limit(int $from, int $offset): QueryBuilder;

  public function order(string $column, string $suffix = null);

  /**
   * $joinType asked:
   *
   * - `0` = INNER JOIN
   * - `1` = LEFT JOIN
   * - `2` = RIGHT JOIN
   * - `3` = FULL JOIN
   */
  public function join(int $joinType, string $table, string $rowTableOne, string $rowTableTwo, string $operator = '='): QueryBuilder;

  public function or(string $row, string $value): QueryBuilder;

  public function getQuery();
}

class MySqlBuilder implements QueryBuilder
{
  private $query;
  private $table;

  public function __construct(string $table)
  {
    $this->table = $table;
  }

  public function init()
  {
    $this->query = new \StdClass;
  }

  public function insert(array $values): QueryBuilder
  {
    $this->init();

    $this->query->base = "INSERT INTO " . $this->table  . " (" . implode(",", array_keys($values)) . ") VALUES (:" . implode(", :", array_keys($values)) . ")";

    return $this;
  }

  public function select(array $columns, string $table =  "default", int $operator = 0 ): QueryBuilder
  {
    $this->init();

    if ($table == "default") {
      $tableSet = $this->table;
    } else {
      $tableSet = $table;
    }

    if ($operator === 1){
      $operatorStart = "MAX(";
      $operatorEnd = ")";
    } else {
      $operatorStart = "";
      $operatorEnd = "";
    }

    $this->query->base = "SELECT " . $operatorStart . implode(', ', $columns) . $operatorEnd . " FROM " . $tableSet;
    return $this;
  }

  public function delete(): QueryBuilder
  {
    $this->init();

    $this->query->base = "DELETE FROM " . $this->table;
    return $this;
  }

  public function update(): QueryBuilder
  {
    $this->init();

    $this->query->base = "UPDATE " . $this->table;
    return $this;
  }

  public function set($columns, string $operator = '='): QueryBuilder
  {
    if (gettype($columns) === 'string') {
      $this->query->set[] = ' ' . $columns . $operator . ":" . $columns;
    } else if (gettype($columns) === 'array') {
      foreach ($columns as $column => $value) {
        $this->query->set[] = $column . $operator . ":" . $column;
      }
    }
    return $this;
  }

  public function where(string $column, string $operator = '=', ?string $table = NULL ): QueryBuilder
  {

    if ($table === NULL) {
      $table = $this->table;
    }

    $this->query->where[] = $table . "." . $column . $operator . ":" . $column;
    return $this;
  }

  public function limit(int $from, int $offset): QueryBuilder
  {
    $this->query->limit = ' LIMIT ' . $from . ', ' . $offset;
    return $this;
  }

  public function order(string $column, string $suffix = null): QueryBuilder
  {
    if ($suffix === null) {
      $this->query->order = ' ORDER BY ' . $column;
    } else {
      $this->query->order = ' ORDER BY ' . $column . ' ' . $suffix;
    }
    return $this;
  }


  /**
   * $joinType asked:
   *
   * - `0` = INNER JOIN
   * - `1` = LEFT JOIN
   * - `2` = RIGHT JOIN
   * - `3` = FULL JOIN
   */
  public function join(int $joinType, string $table, string $rowTableOne, string $rowTableTwo, string $operator = '='): QueryBuilder
  {
    $join = '';

    if ($joinType === 0) {
      $join = 'INNER JOIN ';
    } else if ($joinType === 1) {
      $join = 'LEFT JOIN ';
    } else if ($joinType === 2) {
      $join = 'RIGHT JOIN ';
    } else if ($joinType === 3) {
      $join = 'FULL JOIN ';
    }
    $this->query->join[] = $join . $table . ' ON ' . $this->table . '.' . $rowTableOne . ' ' . $operator . ' ' . $table . '.' . $rowTableTwo;
    return $this;
  }

  public function or(string $row, string $value): QueryBuilder
  {
    $this->query->or[] = $row . ' IS ' . $value;
    return $this;
  }

  public function getQuery()
  {
    $sql = $this->query->base;

    if (isset($this->query->set)) {
      $sql .= " SET " . implode(", ", $this->query->set);
    }

    if (isset($this->query->join)) {
      $sql .= " " . implode(" ", $this->query->join);
    }

    if (!empty($this->query->where)) {
      $sql .= " WHERE " . implode(" AND ", $this->query->where);
    }

    if (isset($this->query->order)) {
      $sql .= " " . $this->query->order;
    }

    if (isset($this->query->limit)) {
      $sql .= " " . $this->query->limit;
    }

    if (isset($this->query->or)) {
      $sql .= " OR " . implode(" OR ", $this->query->or);
    }

    $sql .= ';';

    return $sql;
  }
}

class PostgreBuilder extends MysqlBuilder
{
  public function limit(int $from, int $offset): QueryBuilder
  {
    $this->query->limit = " LIMIT " . $from . "OFFSET " . $offset;
    return $this;
  }
}
