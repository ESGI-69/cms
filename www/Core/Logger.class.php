<?php

namespace App\Core;

use APP\Core\Sql;

class Logger extends Sql
{
  private static $instance = null;
  private $file = null;

  private function __construct()
  {
    if (!file_exists('Logs/')) {
      mkdir('Logs/', 0777);
    }
    $this->file = fopen("Logs/general.log", "a");

    parent::__construct();
  }

  public static function getInstance()
  {
    if (is_null(self::$instance)) {
      self::$instance = new Logger();
    }
    return self::$instance;
  }

  public function add(string $type, string $action)
  {
    $currentTime = date('[Y/m/d, H:i:s]');
    fwrite($this->file, $currentTime . " " . $type . " - " . $action . PHP_EOL);

    $this->saveLog($type, $action);
  }
}
