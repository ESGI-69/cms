<?php

namespace App\Core;

class Verificator
{
  public static function checkForm($config, $data): array
  {
    $result = [];
    // Le nb de inputs envoyés - 1 pour le csrf_token
    if (count($data) - 1 != count($config['inputs'])) {
      // die("Tentative de hack !!!!");
    }

    SecurityManager::checkCsrfToken();

    foreach ($config['inputs'] as $name => $input) {

      if (!isset($data[$name])) {
        if ($input['type'] !== 'file') {
          $result[] = "Le champs " . $name . " n'existe pas";
        } else {
          if ($_FILES["media"]["size"] > 5000000) {
            $result[] = "Image trop lourde";
          }
          $imageFileType = strtolower(pathinfo($_FILES["media"]["name"],PATHINFO_EXTENSION));
          if (
            $imageFileType !== "jpg"
            && $imageFileType !== "png"
            && $imageFileType !== "jpeg"
            && $imageFileType !== "gif"
            && $imageFileType !== "webp"
          ) {
            $result[] = "Votre fichier n'est pas une image";
          }
        }
      }

      if (empty($data[$name]) && !empty($input["required"] && $input["type"] !== "file")) {
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
