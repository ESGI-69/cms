<?php

namespace App\Core;

use App\Core\MySqlBuilder;


abstract class Sql
{
  private $pdo;
  private $table;
  protected $mysqlBuilder;
  private static $instance;

  public function __construct()
  {
    //Se connecter à la bdd
    //TODO il faudra mettre en place le singleton
    try {
      $this->pdo = new \PDO(
        DBDRIVER . ":host=" . DBHOST . ";port=" . DBPORT . ";dbname=" . DBNAME,
        DBUSER,
        DBPWD,
        [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_WARNING]
      );
    } catch (\Exception $e) {
      die("Erreur SQL : " . $e->getMessage());
    }

    //Si l'id n'est pas null alors on fait un update sinon on fait un insert
    $calledClassExploded = explode("\\", get_called_class());
    $this->table = strtolower(DBPREFIXE . end($calledClassExploded));

    $this->mysqlBuilder = new MySqlBuilder($this->table);
  }

  //test singleton
  /**
   * Récupérer l'instance de la classe, si elle n'existe pas elle sera créée
   * automatiquement puis retournée.
   *
   * @return Sql Instance de la classe SQL.
   * @link https://refactoring.guru/design-patterns/singleton
   */

  public function getInstance(): Sql
  {
    if (!isset(self::$instance)) {
      self::$instance = new static();
    }
    return self::$instance;
  }

  //Fin test

  public function verifyEmail(string $emailToken): bool
  {
    // Met la ligne du user a jour en updatant le emailVerifyToken a NULL et le status à 1
    $sql = $this->mysqlBuilder
      ->update()
      ->set('emailVerifyToken')
      ->set('status')
      ->where('emailVerifyToken')
      ->getQuery();

    $options = [
      'emailVerifyToken' => null,
      'status' => 1,
      'emailVerifyToken' => $emailToken
    ];

    $result = $this->executeQuery($sql, 0, $options);

    if ($result->rowCount() === 1) {
      return true;
    }
    return false;
  }

  /**
   * @param int $id
   */
  public function getUserById(?int $id): object
  {
    $sql = $this->mysqlBuilder
      ->select(['*'])
      ->where('id')
      ->getQuery();

    $option = [
      'id' => $id
    ];

    $result = $this->executeQuery($sql, 0, $option);

    $result = $result->fetchObject(get_called_class());

    return $result;
  }

  public function saveUser()
  {

    $columns = get_object_vars($this);
    $columns = array_diff_key($columns, get_class_vars(get_class()));

    /**
     * TODO : create getId() method
     *        or
     *        use Authenticator::getUser()->getId() ?s
     */

    if ($this->getId() === null) {
      $columnsFiltred = $columns;
      unset($columnsFiltred['id']);

      $sql = $this->mysqlBuilder
        ->insert($columnsFiltred)
        ->getQuery();
      $this->executeQuery($sql, 0, $columnsFiltred);
    }

    /**
     * TODO : update a user with save() method
     */
    else {
      $update = [];
      foreach ($columns as $column => $value) {
        $update[] = $column . "=:" . $column;
      }

      $sqlNew = $this->mysqlBuilder
        ->update()
        ->set($columns)
        ->where('id')
        ->getQuery();

      $this->executeQuery($sqlNew, 0, $columns);
    }
  }

  public function saveMedia()
  {
    $columns = get_object_vars($this);
    $columns = array_diff_key($columns, get_class_vars(get_class()));

    if ($this->getId() === null) {
      // save the file
      $target_dir = $columns["mediaRoute"];
      $target_file = $target_dir . $columns["name"] . "." . $columns["mediaType"];
      // $uploadCheck = 1;
      // $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

      // a faire dans le verificator
      // 5MB max
      // if ($_FILES["media"]["size"] > 5000000) {
      //   echo "Image trop lourde";
      //   $uploadCheck = 0;
      // }
      // Allow certain file formats
      // if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
      // && $imageFileType != "gif" ) {
      //   echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
      //   $uploadCheck = 0;
      // }

      // Check if $uploadOk is set to 0 by an error
      // if ($uploadCheck == 0) {
      //   echo "Sorry, your file was not uploaded.";
      // }
      
      //upload the file
      move_uploaded_file($_FILES["media"]["tmp_name"], $target_file);

      $columnsFiltred = $columns;
      unset($columnsFiltred['id']);
      unset($columnsFiltred['mediaType']);
      unset($columnsFiltred['mediaRoute']);

      $sql = $this->mysqlBuilder
        ->insert($columnsFiltred)
        ->getQuery();

      $options = $columnsFiltred;

      $this->executeQuery($sql, 0, $options);
    }
  }

  public function checkExistingMail()
  {
    $columns = get_object_vars($this);
    $columns = array_diff_key($columns, get_class_vars(get_class()));
    $emailExist = false;

    $sql = $this->mysqlBuilder
      ->select(['*'])
      ->where('email')
      ->limit(0, 1)
      ->getQuery();

    $option = [
      'email' => $columns['email']
    ];

    $result = $this->executeQuery($sql, 1, $option);

    if (!empty($result)) {
      $emailExist = true;
    }

    return $emailExist;
  }

  public function login(string $email): array
  {
    $sql = $this->mysqlBuilder
      ->select(['password', 'status', 'token', 'firstname'])
      ->where('email')
      ->limit(0, 1)
      ->getQuery();

    $options = [
      'email' => $email
    ];

    $query = $this->executeQuery($sql, 1, $options);

    if (empty($query)) {
      return [];
    } else {
      return $query;
    }
  }

  public function executeQuery(string $query, int $fetchType, array $option = null)
  {
    /**
     * $fetchType asked:
     *
     * - `0` = no fetch
     * - `1` = fetch
     * - `2` = fetchAll
     */
    if ($fetchType === 0) {
      $result = $this->pdo->prepare($query);
      $result->execute($option);
      return $result;
    }

    $query = $this->pdo->prepare($query);

    if ($fetchType === 1) {
      $query->execute($option);
      return $query->fetch();
    } elseif ($fetchType === 2) {
      $query->execute($option);
      return $query->fetchAll();
    }
  }
}
