<?php

namespace App\Model;

use App\Core\Sql;

class Media extends Sql
{
  protected $id = null;
  protected $name = null;
  protected $size = null;
  protected $user_id = null;

  public function __construct()
  {
    parent::__construct();
  }

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getName(): ?string
  {
    return $this->name;
  }

  public function setName(?string $name): void
  {
    $this->name = mb_strimwidth(
      trim(
        preg_replace('/-+/', '-', preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', strtolower($name)))), '-'), 0, 92) . "-" . date('y-m-d');
  }

  public function getSize(): ?int
  {
    return $this->size;
  }

  public function setSize(?int $size): void
  {
    $this->size = $size;
  }

  public function getUserId(): ?int
  {
    return $this->user_id;
  }

  public function setUserId(?int $user_id): void
  {
    $this->user_id = $user_id;
  }

  


}
