<?php

namespace App\Core;

use App\Model\User;

class AuthManager
{
  public static function isAuth(): bool
  {
    return isset($_COOKIE['wikikiToken']);
  }

  public static function userInfos(): ?array
  {
    $userInfos = null;
    if (self::isAuth()) {
      $user = new User();
      $user->setToken($_COOKIE['wikikiToken']);
      $userInfos = $user->getUserInfos();
    }
    return $userInfos;
  }
}
