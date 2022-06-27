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
  /**
   * @var int Role de l'utilisateur :
   * 
   * - `1` = administrateur
   * - `2` = modérateur
   * - `3` = utilisateur
   */
  protected $role = 3;

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

  public function setId($id): void
  {
    $this->id = $id;
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
   * @return int
   */
  public function getRole(): int
  {
    return $this->role;
  }

  /**
   * @param int $role
   */
  public function setRole(int $role): void
  {
    $this->role = $role;
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
    $sql = $this->mysqlBuilder
      ->select(['*'])
      ->where('token')
      ->getQuery();
    $option = [
      'token' => $this->token
    ];
    $result = $this->executeQuery($sql, 2, $option);
    $this->setEmail($result[0]->email);
    $this->setFirstname($result[0]->firstname);
    $this->setLastname($result[0]->lastname);
    $this->setId($result[0]->id);
    $this->setStatus($result[0]->status);
    $this->setRole($result[0]->role);

    return [
      'id' => $this->getId(),
      'firstname' => $this->getFirstname(),
      'lastname' => $this->getLastname(),
      'email' => $this->getEmail(),
      'status' => $this->getStatus(),
      'role' => $this->getRole(),
    ];
  }

  public function getAllAdmins(): array
  {
    $sql = $this->mysqlBuilder
      ->select(['*'])
      ->where('role', '=')
      ->order('id')
      ->getQuery();

    return $this->executeQuery($sql, 2, ['role' => 1]);
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
        "submit" => "S'inscrire",
        "success" => "Votre compte a bien été créé !",
      ],
      'inputs' => [
        "email" => [
          "type" => "email",
          "placeholder" => "Votre email ...",
          "required" => true,
          "class" => "input",
          "id" => "emailForm",
          "error" => "Email incorrect",
          "unicity" => "true",
          "errorUnicity" => "Email déjà en bdd",
        ],
        "password" => [
          "type" => "password",
          "placeholder" => "Votre mot de passe ...",
          "required" => true,
          "class" => "input",
          "id" => "pwdForm",
          "error" => "Votre mot de passe doit faire au min 8 caractères avec majuscule, minuscules et des chiffres",
        ],
        "passwordConfirm" => [
          "type" => "password",
          "placeholder" => "Confirmation ...",
          "required" => true,
          "class" => "input",
          "id" => "pwdConfirmForm",
          "confirm" => "password",
          "error" => "Votre mot de passe de confirmation ne correspond pas",
        ],
        "firstname" => [
          "type" => "text",
          "placeholder" => "Votre prénom ...",
          "class" => "input",
          "id" => "firstnameForm",
          "min" => 2,
          "max" => 50,
          "error" => "Prénom incorrect"
        ],
        "lastname" => [
          "type" => "text",
          "placeholder" => "Votre nom ...",
          "class" => "input",
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
      echo "Impossible d'assigner les properties du Model User";
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
          "class" => "input",
          "id" => "emailForm",
          "error" => "Email incorrect"
        ],
        "password" => [
          "type" => "password",
          "placeholder" => "Votre mot de passe ...",
          "required" => true,
          "class" => "input",
          "id" => "pwdForm",
          "error" => "Email ou mot de passe invalide"
        ]
      ]
    ];
  }

  public function setLoginInfo(): void
  {
    try {
      $this->setEmail($_POST['email']);
    } catch (Exception $e) {
      echo "Impossible d'assigner les properties du Model User";
      print_r($e);
    }
  }
}
