<?php

namespace App\Core;

interface QueryBuilder
{
  public function insert(array $values): QueryBuilder;

  public function select(array $columns): QueryBuilder;

  public function delete(): QueryBuilder;

  public function update(): QueryBuilder;

  public function set($column, string $operator = '='): QueryBuilder;

  public function where(string $column, string $operator = '='): QueryBuilder;

  public function limit(int $from, int $offset): QueryBuilder;

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

  public function select(array $columns): QueryBuilder
  {
    $this->init();

    $this->query->base = "SELECT " . implode(', ', $columns) . " FROM " . $this->table;
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

  public function where(string $column, string $operator = '='): QueryBuilder
  {

    $this->query->where[] = $column . $operator . ":" . $column;
    return $this;
  }

  public function limit(int $from, int $offset): QueryBuilder
  {
    $this->query->limit = ' LIMIT ' . $from . ', ' . $offset;
    return $this;
  }

  public function getQuery()
  {
    $sql = $this->query->base;

    if (isset($this->query->set)) {
      $sql .= " SET " . implode(", ", $this->query->set);
    }

    if (!empty($this->query->where)) {
      $sql .= " WHERE " . implode(" AND ", $this->query->where);
    }

    if (isset($this->query->limit)) {
      $sql .= " " . $this->query->limit;
    }

    $sql .= ';';

    return $sql;
  }
}
