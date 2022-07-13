<?php

namespace App\Core;

use App\Model\Log as LogModel;

class Logger
{
  private static $instance = null;
  private $file = null;

  private function __construct()
  {
    if (!file_exists('Logs/')) {
      mkdir('Logs/', 0777);
    }
    $this->file = fopen("Logs/general.log", "a");
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

    $log = new LogModel();

    $log->setType($type);
    $log->setAction($action);

    $log->save();
  }
}
