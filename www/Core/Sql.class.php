<?php

namespace App\Core;

use App\Core\MySqlBuilder;


abstract class Sql extends MySqlBuilder
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

    $this->mysqlBuilder = new MySqlBuilder();
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
    $sqlOld = "UPDATE wk_user SET emailVerifyToken=null, status=1 WHERE emailVerifyToken='" . $emailToken . "'";
    $sql = $this->mysqlBuilder
      ->update($this->table)
      ->set('emailVerifyToken', 'null')
      ->set('status', '1')
      ->where('emailVerifyToken', $emailToken)
      ->getQuery();

    $result = $this->executeQuery($sql, 0);

    if ($result->rowCount() === 1) {
      return true;
    }
    return false;
  }

  /**
   * @param int $id
   */
  public function setId(?int $id): object
  {
    $sql = $this->mysqlBuilder
      ->select($this->table, ['*'])
      ->where('id', $id)
      ->getQuery();

    $result = $this->executeQuery($sql, 0);

    $result = $result->fetchObject(get_called_class());

    return $result;
  }

  public function save()
  {

    $columns = get_object_vars($this);
    $columns = array_diff_key($columns, get_class_vars(get_class()));

    if ($this->getId() == null) {
      $columnsFiltred = $columns;
      unset($columnsFiltred['id']);

      $sql = $this->mysqlBuilder
        ->insert($this->table, $columnsFiltred)
        ->getQuery();
    } 
    // non géré encore
    else {
      $update = [];
      foreach ($columns as $column => $value) {
        $update[] = $column . "=:" . $column;
      }
      $sql = "UPDATE " . $this->table . " SET " . implode(",", $update) . " WHERE id=" . $this->getId();
    }

    $this->executeQuery($sql, 0);
  }

  public function checkExistingMail()
  {
    $columns = get_object_vars($this);
    $columns = array_diff_key($columns, get_class_vars(get_class()));
    $emailExist = false;

    $sql = $this->mysqlBuilder
      ->select($this->table, ['*'])
      ->where('email', $columns['email'])
      ->getQuery();

    $result = $this->executeQuery($sql, 2);

    if (!empty($result)) {
      $emailExist = true;
    }
    return $emailExist;
  }

  public function login(string $email): array
  {
    $sql = $this->mysqlBuilder
      ->select($this->table, ['password', 'status', 'token', 'firstname'])
      ->where('email', $email)
      ->limit(0, 1)
      ->getQuery();
    $query = $this->executeQuery($sql, 1);

    if (empty($query)) {
      return [];
    } else {
      return $query;
    }
  }

  public function executeQuery(string $query, int $fetchType = 0)
  {
    /**
     * $fetchType demandé:
     *
     * - `0` = no fetch
     * - `1` = fetch
     * - `2` = fetchAll
     */
    if ($fetchType === 0) {
      // query prepare et execute
      $result = $this->pdo->prepare($query);
      $result->execute();
      return $result;
    }

    $query = $this->pdo->prepare($query);

    if ($fetchType === 1) {
      $query->execute();
      return $query
        ->fetch();
    } elseif ($fetchType === 2) {
      $query->execute();
      return $query->fetchAll();
    }
  }
}
