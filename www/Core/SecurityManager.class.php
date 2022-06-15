<?php

namespace App\Core;

class SecurityManager
{
  public static function checkCsrfToken()
  {
    if (empty($_SESSION['csrf_token'])) {
      die('MISSING CSRF TOKEN');
    } elseif ($_SESSION['csrf_token'] !== $_POST['csrf_token']) {
      die('INVALID CSRF TOKEN');
    } else {
      unset($_SESSION['csrf_token']);
      return true;
    }
  }
}
