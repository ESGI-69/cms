<?php

namespace App\Controller;

use App\Core\Verificator;
use App\Core\View;

use App\Model\Log as LogModel;

class Log
{
  public function logsShow()
  {
    $log = new LogModel();

    $this->logs = $log->getAll();

    $view = new View("logsList", "back", "Logs");
    $view->assign("logs", $this->logs);
  }
}
