<?php

namespace App\Model;

use App\Core\Sql;

class Log extends Sql
{
  protected $id = null;
  protected $type = null;
  protected $action = null;

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

  public function setType(?string $type): void
  {
    $this->type = htmlspecialchars(trim($type), ENT_COMPAT);
  }

  public function getType(): ?string
  {
    return $this->type;
  }

  public function setAction(?string $action): void
  {
    $this->action = htmlspecialchars(trim($action), ENT_COMPAT);
  }

  public function getAction(): ?string
  {
    return $this->action;
  }

  public function getLogInfo(?string $id): array
  {
    $this->setId($id);
    $result = $this->get($this->getId());
    if (isset($result)) {
      $this->setType($result['type']);
      $this->setAction($result['action']);
      return [
        'id' => $this->getId(),
        'type' => $this->getType(),
        'action' => $this->getAction(),
      ];
    }
  }
}
