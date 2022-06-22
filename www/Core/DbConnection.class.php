<?php

namespace App\Core;

class DbConnection
{
  private static $instance = null;
  public $pdo;

  // a faire dans le construc de Sql
  // $this->pdo = DbConnection::getInstance()->pdo;


  private function __construct()
  {
    //Se connecter à la bdd
    try{
      $this->pdo = new \PDO( DBDRIVER.":host=".DBHOST.";port=".DBPORT.";dbname=".DBNAME
        ,DBUSER, DBPWD , [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_WARNING]);
    }catch (\Exception $e){
      die("Erreur SQL : ".$e->getMessage());
    }
  }

  /**
   * Récupérer l'instance de la classe, si elle n'existe pas elle sera créée
   * automatiquement puis retournée.
   *
   * @return Sql Instance de la classe SQL.
   * @link https://refactoring.guru/design-patterns/singleton
   */

  /** 
   * design pattern lesson example
   public static function getInstance()
   {
      if (is_null(self::$instance)) {
        self::$instance = new MasterRing();
      }
      return self::$instance;
    }
  */

  public static function getInstance() {
    if (is_null(self::$instance)) {
      self::$instance = new DbConnection();
    }
    return self::$instance;
  }

}