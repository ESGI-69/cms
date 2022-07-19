<?php

namespace App\Model;

use App\Core\Sql;

class Meta extends Sql
{
  protected $id = null;
  protected $type = null;
  protected $value = null;

  public function __construct()
  {
    parent::__construct();
  }

  protected function setId($id)
  {
    $this->id = $id;
  }

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getType(): ?string
  {
    return $this->type;
  }

  public function setType(?string $type): void
  {
    $this->type = htmlspecialchars(trim($type), ENT_COMPAT);
  }

  public function getValue(): ?string
  {
    return $this->value;
  }

  public function setValue(?string $value): void
  {
    $this->value = htmlspecialchars(trim($value), ENT_COMPAT);
  }

  public function setMetainfo(): void
  {
    $this->setType($_POST['type']);
    $this->setValue($_POST['value']);
  }

}