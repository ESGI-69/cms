<?php

namespace App\Core;

abstract class Sql
{
  private $pdo;
  private $table;
  private static $instance;

  public function __construct()
  {
    //Se connecter à la bdd
    //TODO il faudra mettre en place le singleton
    try{
      $this->pdo = new \PDO( DBDRIVER.":host=".DBHOST.";port=".DBPORT.";dbname=".DBNAME
        ,DBUSER, DBPWD , [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_WARNING]);
    }catch (\Exception $e){
      die("Erreur SQL : ".$e->getMessage());
    }

    //Si l'id n'est pas null alors on fait un update sinon on fait un insert
    $calledClassExploded = explode("\\",get_called_class());
    $this->table = strtolower(DBPREFIXE.end($calledClassExploded));
  }

  //test singleton
  /**
   * Récupérer l'instance de la classe, si elle n'existe pas elle sera créée
   * automatiquement puis retournée.
   *
   * @return Sql Instance de la classe SQL.
   * @link https://refactoring.guru/design-patterns/singleton
   */

  public function getInstance(): Sql {
    if (!isset(self::$instance)) {
      self::$instance = new static();
    }
    return self::$instance;
  }

  //Fin test

  public function verifyEmail(string $emailToken): bool
  {
    // Met la ligne du user a jour en updatant le emailVerifyToken a NULL et le status à 1
    $sql = "UPDATE wk_user SET emailVerifyToken=null, status=1 WHERE emailVerifyToken = :emailToken";

    $sqlStatement = $this->pdo->prepare($sql);
    $sqlStatement->bindParam('emailToken', $emailToken);
    $sqlStatement->execute();
    if($sqlStatement->rowCount() === 1){
      return true;
    }
    return false;
  }

  /**
   * @param int $id
   */
  public function setId(?int $id): object
  {
    $sql = "SELECT * FROM ".$this->table." WHERE id=".$id;
    $query = $this->pdo->query($sql);
    return $query->fetchObject(get_called_class());
  }

  public function save()
  {

    $columns = get_object_vars($this);
    $columns = array_diff_key($columns, get_class_vars(get_class()));

    if($this->getId() == null){
      $sql = "INSERT INTO ".$this->table." (".implode(",",array_keys($columns)).") 
            VALUES ( :".implode(",:",array_keys($columns)).")";
    } else{
      $update = [];
      foreach ($columns as $column=>$value)
      {
        $update[] = $column."=:".$column;
      }
      $sql = "UPDATE ".$this->table." SET ".implode(",",$update)." WHERE id=".$this->getId() ;

    }

    $queryPrepared = $this->pdo->prepare($sql);
    $queryPrepared->execute( $columns );

  }

  public function login(string $email): array
  {
    $sql = "SELECT password, status, token, firstname FROM ".$this->table." WHERE email= :email";
    $queryStatement = $this->pdo->prepare($sql);
    $queryStatement->bindParam('email', $email );
    $queryStatement->execute();
    $query = $queryStatement->fetch();
    if ($query === false){
      return [];
    } else {
      return $query;
    }
  }
}
