<?php

namespace App\Core;

use App\Core\MySqlBuilder;


abstract class Sql
{
  private $pdo;
  private $table;
  protected $mysqlBuilder;

  public function __construct()
  {
    //Se connecter à la bdd
    //TODO il faudra mettre en place le singleton
    $this->pdo = DbConnection::getInstance()->pdo;

    //Si l'id n'est pas null alors on fait un update sinon on fait un insert
    $calledClassExploded = explode("\\", get_called_class());
    $this->table = strtolower(DBPREFIXE . end($calledClassExploded));

    $this->mysqlBuilder = new MySqlBuilder($this->table);
  }

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
  public function get(?int $id): object
  {
    $sql = $this->mysqlBuilder
      ->select(['*'])
      ->where('id')
      ->getQuery();

    $option = [
      'id' => $id
    ];

    $result = $this->executeQuery($sql, 1, $option);

    return $result;
  }

  public function getJoin(int $id, string $table, string $rowA, string $rowB)
  {
    $sql = $this->mysqlBuilder
      ->select(['*'])
      ->join(0, $table, $rowA, $rowB)
      ->where('id')
      ->getQuery();

    $option = [
      'id' => $id
    ];

    $result = $this->executeQuery($sql, 2, $option);
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
     * TODO : update an user with save()method : 
     *        send his id through the form
     *        or
     *        update the user where token = $_COOKIE['wikikiToken']
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

  public function savePage()
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
     * TODO : update an user with save()method : 
     *        send his id through the form
     *        or
     *        update the user where token = $_COOKIE['wikikiToken']
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
      $target_dir = $columns["mediaRoute"];
      $target_file = $target_dir . $columns["name"] . "." . $columns["mediaType"];

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

  public function edit()
  {
    $columns = get_object_vars($this);
    $columns = array_diff_key($columns, get_class_vars(get_class()));

    echo "<pre>";
    print_r($columns);
    echo "</pre>";

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

  public function saveCategory()
  {
    $columns = get_object_vars($this);
    $columns = array_diff_key($columns, get_class_vars(get_class()));

    if ($this->getId() === null) {

      $columnsFiltred = $columns;
      unset($columnsFiltred['id']);

      $sql = $this->mysqlBuilder
        ->insert($columnsFiltred)
        ->getQuery();

      $options = $columnsFiltred;

      $this->executeQuery($sql, 0, $options);
    }
  }

  public function checkExisting(string $where)
  {
    $columns = get_object_vars($this);
    $columns = array_diff_key($columns, get_class_vars(get_class()));
    $emailExist = false;

    $sql = $this->mysqlBuilder
      ->select(['*'])
      ->where($where)
      ->limit(0, 1)
      ->getQuery();

    $option = [
      $where => $columns[$where]
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

  /**
   * $fetchType asked:
   *
   * - `0` = no fetch
   * - `1` = fetch
   * - `2` = fetchAll
   * - `3` = for join queries
   */
  public function executeQuery(string $query, int $fetchType, array $option = null)
  {
    if ($fetchType === 0) {
      $result = $this->pdo->prepare($query);
      $result->execute($option);
      return $result;
    }

    $query = $this->pdo->prepare($query);
    $query->setFetchMode($this->pdo::FETCH_OBJ);

    if ($fetchType === 1) {
      $query->execute($option);
      return $query->fetch();
    } elseif ($fetchType === 2) {
      $query->execute($option);
      return $query->fetchAll();
    }
  }

  public function getAll(): array
  {
    $sql = $this->mysqlBuilder
      ->select(['*'])
      ->order('id')
      ->getQuery();

    return $this->executeQuery($sql, 2);
  }

  public function delete($id)
  {
    $sql = $this->mysqlBuilder
      ->delete()
      ->where('id')
      ->getQuery();

    $option = [
      'id' => $id
    ];

    $this->executeQuery($sql, 0, $option);
  }
}

