<?php

namespace App\Model;

use App\Core\Sql;

class Category extends Sql
{
  protected $id = null;
  protected $name = null;

  public function __construct()
  {
    parent::__construct();
  }

  /**
   * @return null|int
   */
  public function getId(): ?int
  {
    return $this->id;
  }
}
