<?php

namespace App\Core;

class Verificator
{
  public static function checkForm($config, $data): array
  {
    $result = [];
    // Le nb de inputs envoyés - 1 pour le csrf_token
    if (count($data) - 1 != count($config['inputs'])) {
      die("Tentative de hack !!!!");
    }

    SecurityManager::checkCsrfToken();

    foreach ($config['inputs'] as $name => $input) {

      if (!isset($data[$name])) {
        $result[] = "Le champs " . $name . " n'existe pas";
      }

      if (empty($data[$name]) && !empty($input["required"])) {
        $result[] = "Le champs " . $name . " ne peut pas être vide";
      }

      if ($input["type"] == "email" && !self::checkEmail($data[$name])) {
        $result[] = $input["error"];
      }

      if ($input["type"] == "password" && empty($input["confirm"]) && !self::checkPassword($data[$name])) {
        $result[] = $input["error"];
      }

      if (!empty($input["confirm"]) && $data[$name] != $data[$input["confirm"]]) {
        $result[] = $input["error"];
      }
    }
    return $result;
  }

  public static function checkEmail($email): bool
  {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
  }

  public static function checkPassword($password): bool
  {
    return strlen($password) >= 8
      && preg_match("/[0-9]/", $password, $match)
      && preg_match("/[a-z]/", $password, $match)
      && preg_match("/[A-Z]/", $password, $match);
  }
}
