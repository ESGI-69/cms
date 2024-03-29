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
  public function get(?int $id)
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


  public function getHighest(?string $item, ?string $table)
  {
    $sql = $this->mysqlBuilder
      ->select(['*'], $table)
      ->order($item, 'DESC')
      ->limit(0, 1)
      ->getQuery();

    $result = $this->executeQuery($sql, 1);
    return $result;
  }

  public function getWhere(string $table, string $nameRow, string $value): int
  {
    $sql = $this->mysqlBuilder
      ->select(['*'], $table)
      ->where($nameRow, '=', $table)
      ->getQuery();

    $option = [
      $nameRow => $value
    ];

    $result = $this->executeQuery($sql, 1, $option);

    return $result->id;
  }

  public function getNoModel(string $whereRow, $whereValue, string $table)
  {
    $sql = $this->mysqlBuilder
      ->select(['*'], $table)
      ->where($whereRow, '=', $table)
      ->getQuery();

    $option = [
      $whereRow => $whereValue
    ];

    $result = $this->executeQuery($sql, 2, $option);

    return $result;
  }

  public function getMeta(string $element)
  {
    $sql = $this->mysqlBuilder
      ->select(['value'])
      ->where('type', '=')
      ->getQuery();

    $option = [
      'type' => $element
    ];
    $result = $this->executeQuery($sql, 1, $option);
    return $result->value;
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

  public function save(): string
  {

    $columns = get_object_vars($this);
    $columns = array_diff_key($columns, get_class_vars(get_class()));

    /**
     * TODO : create getId() method
     *        or
     *        use Authenticator::getUser()->getId() ?s
     */
    if ($this->getId()=== -1){
      $columns['id'] = 1;
      $sql = $this->mysqlBuilder
        ->insert($columns)
        ->getQuery();
      $this->executeQuery($sql, 0, $columns);
    } else if ($this->getId() === null) {
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

    return $this->pdo->lastInsertId();
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

  public function saveLog(string $type, string $action)
  {
    $sql = $this->mysqlBuilder
      ->insert(['type' => 'type', 'action' => 'action'])
      ->getQuery();

    $options = [
      'type' => $type,
      'action' => $action
    ];

    $this->executeQuery($sql, 0, $options);
  }

  public function edit()
  {
    $columns = get_object_vars($this);
    $columns = array_diff_key($columns, get_class_vars(get_class()));

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
      $emailExist = $result->id;
    }
    if ($result) {
      if ($columns["id"] === $result->id) {
        $emailExist = false;
      }
    }

    return $emailExist;
  }

  public function mailedChanged()
  {
    $columns = get_object_vars($this);
    $columns = array_diff_key($columns, get_class_vars(get_class()));
    $emailChanged = false;

    $sql = $this->mysqlBuilder
      ->select(['*'])
      ->where('email')
      ->limit(0, 1)
      ->getQuery();

    $option = [
      'email' => $columns['email']
    ];

    $result = $this->executeQuery($sql, 1, $option);

    if (empty($result)) {
      $emailChanged = true;
    }

    return $emailChanged;
  }

  public function isDatabaseEmpty()
  {
    $tables = [
      'article',
      'category',
      'comment',
      'log',
      'media',
      'navigation',
      'page',
      'passwordreset',
      'user',
    ];
    $fail = false;
    foreach ($tables as $table) {
      $result = $this->executeQuery("SHOW TABLES LIKE '" . DBPREFIXE . $table . "';", 1);
      if (empty($result)) {
        $fail = true;
        break;
      }
    }
    return $fail;
  }

  public function initializeDatabase()
  {
    $this->pdo->exec(file_get_contents(__DIR__ . '/../wikiki.sql'));
  }

  public function login(string $email)
  {
    $sql = $this->mysqlBuilder
      ->select(['password', 'status', 'token', 'firstname', 'email'])
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
   * - `3` = count rows
   */
  public function executeQuery(string $query, int $fetchType, array $option = null)
  {
    $query = $this->pdo->prepare($query);
    if ($fetchType === 0) {
      $query->execute($option);
      return $query;
    }

    if ($fetchType === 3) {
      $query->execute($option);
      return $query->rowCount();
    }

    $query->setFetchMode($this->pdo::FETCH_OBJ);

    if ($fetchType === 1) {
      $query->execute($option);
      return $query->fetch();
    } elseif ($fetchType === 2) {
      $query->execute($option);
      return $query->fetchAll();
    }
  }

  public function getAll(string $order = 'id'): array
  {
    $sql = $this->mysqlBuilder
      ->select(['*'])
      ->order($order)
      ->getQuery();

    return $this->executeQuery($sql, 2);
  }

  public function getLast(int $quantity): array
  {
    $sql = $this->mysqlBuilder
      ->select(['*'])
      ->order('createdAt', 'DESC')
      ->limit(0, $quantity)
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

  public function where(string $columnName, string $columnValue)
  {
    $sql = $this->mysqlBuilder
      ->select(['*'])
      ->where($columnName)
      ->getQuery();

    $option = [
      $columnName => $columnValue
    ];

    $query = $this->executeQuery($sql, 2, $option);

    if (empty($query)) {
      return [];
    } else {
      return $query;
    }
  }

  public function countRows(?string $table = null)
  {
    if ($table === null) {
      $table = $this->table;
    }

    $sql = $this->mysqlBuilder
      ->select(['*'], $table)
      ->getQuery();

    $result = $this->executeQuery($sql, 3);

    return $result;
  }

  public function incrementView(int $id, array $set)
  {
    $getValue = $this->mysqlBuilder
      ->select($set)
      ->where('id')
      ->limit(0, 1)
      ->getQuery();

    $optionGetValue = [
      'id' => $id
    ];
    $value = $this->executeQuery($getValue, 1, $optionGetValue);
    $extractSet = $set[0];
    $value = $value->$extractSet;
    $value++;

    $sql = $this->mysqlBuilder
      ->update()
      ->set('clickedOn')
      ->where('id')
      ->getQuery();

    $option = [
      'id' => $id,
      'clickedOn' => $value
    ];

    $this->executeQuery($sql, 0, $option);
  }
}
