<?php

namespace App\Model;

use App\Core\Sql;

class PasswordReset extends Sql
{
  protected $id = null;
  protected $email = null;
  protected $changeKey = null;
  protected $expDate = null;
  protected $user_id = null;

  public function __construct()
  {
    parent::__construct();
  }

  public function setId($id)
  {
    $this->id = $id;
  }

  public function getId(): ?int
  {
    return $this->id;
  }

  public function setEmail(?string $email): void
  {
    $this->email = htmlspecialchars(trim($email), ENT_COMPAT);
  }

  public function getEmail(): ?string
  {
    return $this->email;
  }

  public function setChangeKey(?string $changeKey): void
  {
    $this->changeKey = htmlspecialchars(trim($changeKey), ENT_COMPAT);
  }

  public function getChangeKey(): ?string
  {
    return $this->changeKey;
  }

  public function setExpDate(?string $expDate): void
  {
    $this->expDate = htmlspecialchars(trim($expDate), ENT_COMPAT);
  }

  public function getExpDate(): ?string
  {
    return $this->expDate;
  }

  public function setUserId($user_id): void
  {
    $this->user_id = htmlspecialchars(trim($user_id), ENT_COMPAT);
  }

  public function getUserId(): ?string
  {
    return $this->user_id;
  }

  public function getPasswordResetInfo(?string $id): array
  {
    $this->setId($id);
    $result = $this->get($this->getId());
    if (isset($result)) {
      $this->setEmail($result->email);
      $this->setChangeKey($result->changeKey);
      $this->setExpDate($result->expDate);
      $this->setUserId($result->user_id);
      return [
        'id' => $this->getId(),
        'email' => $this->getEmail(),
        'key' => $this->getChangeKey(),
        'exp_date' => $this->getExpDate(),
        'user_id' => $this->getUserId(),
      ];
    }
  }
}
