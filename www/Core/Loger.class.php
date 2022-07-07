<?php

namespace App\Core;

class Loger
{
  private static $instance = null;
  private $file = null;

  private function __construct()
  {
    if (!file_exists('Logs/')){
      mkdir('Logs/',0777);
    }
    $this->file = fopen("Logs/general.log", "a");
  }

  public static function getInstance()
  {
    if (is_null(self::$instance)) {
      self::$instance = New Loger();
    }
    return self::$instance;
  }

  public function save(string $action) 
  {
    $currentTime = date('[Y/m/d, H:i:s]');
    fwrite($this->file, $currentTime." ".$action.PHP_EOL);
  }

}