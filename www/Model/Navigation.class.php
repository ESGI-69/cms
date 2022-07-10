<?php

namespace App\Model;

use App\Core\Sql;

class Navigation extends Sql
{
  protected $id = null;
  protected $value = null;
  protected $name = null;

  public function __construct()
  {
    parent::__construct();
  }

  protected function setId($id)
  {
    $this->id = $id;
  }

  /**
   * @return null|int
   */
  public function getId(): ?int
  {
    return $this->id;
  }

  public function getName()
  {
    return $this->name;
  }

  protected function setName(?string $name): void
  {
    $this->name = $name;
  }

  public function getValue()
  {
    return $this->value;
  }

  protected function setValue(?string $value): void
  {
    $this->value = $value;
  }
}
