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

  public static function checkPermission(int $requiredRole): bool
  {
    return self::isAuth() && self::userInfos()['role'] <= $requiredRole;
  }

  public static function isAdmin(): bool
  {
    return self::checkPermission(1);
  }

  public static function isMod(): bool
  {
    return self::checkPermission(2);
  }

  public static function isUser(): bool
  {
    return self::checkPermission(3);
  }
}
