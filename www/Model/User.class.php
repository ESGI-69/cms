<?php

namespace App\Model;

use App\Core\Sql;
use PHPMailer\PHPMailer\Exception;

class User extends Sql
{
  protected $id = null;
  protected $firstname = null;
  protected $lastname = null;
  protected $email;
  protected $password;
  /**
   * @var int État de l'utilisateur :
   *
   * - `0` = pas vérifié : connection impossible
   * - `1` = email vérifié : compte activé
   * - `2` = bloqué/désactivé : connection impossible
   */
  protected $status = 0;
  protected $token = null;
  protected $emailVerifyToken = null;

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

  /**
   * @return null|string
   */
  public function getFirstname(): ?string
  {
    return $this->firstname;
  }

  /**
   * @param string $firstname
   */
  public function setFirstname(?string $firstname): void
  {
    $this->firstname = ucwords(strtolower(trim($firstname)));
  }

  /**
   * @return null|string
   */
  public function getLastname(): ?string
  {
    return $this->lastname;
  }

  /**
   * @param null|string
   */
  public function setLastname(?string $lastname): void
  {
    $this->lastname = strtoupper(trim($lastname));
  }

  /**
   * @return string
   */
  public function getEmail(): string
  {
    return $this->email;
  }

  /**
   * @param string $email
   */
  public function setEmail(string $email): void
  {
    $this->email = strtolower(trim($email));
  }

  /**
   * @return string
   */
  public function getPassword(): string
  {
    return $this->password;
  }

  /**
   * @param string $password
   */
  public function setPassword(string $password): void
  {
    $this->password = password_hash($password, PASSWORD_DEFAULT);
  }

  /**
   * @return int
   */
  public function getStatus(): int
  {
    return $this->status;
  }

  /**
   * @param int $status
   */
  public function setStatus(int $status): void
  {
    $this->status = $status;
  }

  /**
   * @return null|string
   */
  public function getToken(): ?string
  {
    return $this->token;
  }

  /**
   * @param null|string $token
   */
  public function setToken(?string $token): void
  {
    $this->token = $token;
  }

  /**
   * @return Object|null
   */
  public function getUserInfos(): array
  {
    $sql = "SELECT * FROM wk_user WHERE token = :token";
    $result = $this->executeQuery($sql, [
      'token' => $this->getToken()
    ]);
    $this->setEmail($result[0]['email']);
    $this->setFirstname($result[0]['firstname']);
    $this->setLastname($result[0]['lastname']);
    $this->setId($result[0]['id']);
    $this->setStatus($result[0]['status']);

    return [
      'id' => $this->getId(),
      'firstname' => $this->getFirstname(),
      'lastname' => $this->getLastname(),
      'email' => $this->getEmail(),
      'status' => $this->getStatus(),
    ];
  }

  /**
   * length : 255
   */
  public function generateToken(): void
  {
    $this->token = substr(bin2hex(random_bytes(128)), 0, 255);
  }

  public function getEmailToken(): ?string
  {
    return $this->emailVerifyToken;
  }

  public  function generateEmailToken(): void
  {
    $this->emailVerifyToken = substr(bin2hex(random_bytes(128)), 0, 64);
  }

  public function getRegisterForm(): array
  {
    return [
      "config" => [
        "method" => "POST",
        "action" => "",
        "submit" => "S'inscrire"
      ],
      'inputs' => [
        "email" => [
          "type" => "email",
          "placeholder" => "Votre email ...",
          "required" => true,
          "class" => "inputForm",
          "id" => "emailForm",
          "error" => "Email incorrect",
          "unicity" => "true",
          "errorUnicity" => "Email déjà en bdd",
        ],
        "password" => [
          "type" => "password",
          "placeholder" => "Votre mot de passe ...",
          "required" => true,
          "class" => "inputForm",
          "id" => "pwdForm",
          "error" => "Votre mot de passe doit faire au min 8 caractères avec majuscule, minuscules et des chiffres",
        ],
        "passwordConfirm" => [
          "type" => "password",
          "placeholder" => "Confirmation ...",
          "required" => true,
          "class" => "inputForm",
          "id" => "pwdConfirmForm",
          "confirm" => "password",
          "error" => "Votre mot de passe de confirmation ne correspond pas",
        ],
        "firstname" => [
          "type" => "text",
          "placeholder" => "Votre prénom ...",
          "class" => "inputForm",
          "id" => "firstnameForm",
          "min" => 2,
          "max" => 50,
          "error" => "Prénom incorrect"
        ],
        "lastname" => [
          "type" => "text",
          "placeholder" => "Votre nom ...",
          "class" => "inputForm",
          "id" => "lastnameForm",
          "min" => 2,
          "max" => 100,
          "error" => "Nom incorrect"
        ],
      ]
    ];
  }

  /**
   * Assign les données du $_POST dans les properties de la class
   * pour quelles puissent etre enregistrées en base.
   * @return void
   */
  public function setRegisterInfo(): void
  {
    try {
      $this->generateToken();
      $this->generateEmailToken();
      $this->setEmail($_POST['email']);
      $this->setPassword($_POST['password']);
      $this->setFirstname($_POST['firstname']);
      $this->setLastname($_POST['lastname']);
    } catch (Exception $e) {
      echo "Impossible d'assigner les propetries du Model User";
      print_r($e);
    }
  }

  public function getLoginForm(): array
  {
    return [
      "config" => [
        "method" => "POST",
        "action" => "",
        "submit" => "Se connecter"
      ],
      'inputs' => [
        "email" => [
          "type" => "email",
          "placeholder" => "Votre email ...",
          "required" => true,
          "class" => "inputForm",
          "id" => "emailForm",
          "error" => "Email incorrect"
        ],
        "password" => [
          "type" => "password",
          "placeholder" => "Votre mot de passe ...",
          "required" => true,
          "class" => "inputForm",
          "id" => "pwdForm",
          "error" => "Mot de passe incorrect"
        ]
      ]
    ];
  }

  public function setLoginInfo(): void
  {
    try {
      $this->setEmail($_POST['email']);
    } catch (Exception $e) {
      echo "Impossible d'assigner les propetries du Model User";
      print_r($e);
    }
  }
}
