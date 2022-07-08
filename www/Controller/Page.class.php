<?php

namespace App\Controller;

use App\Core\CleanWords;
use App\Core\Sql;
use App\Core\Verificator;
use App\Core\View;
use App\Model\Page as PageModel;

class Page
{
  public function pagesList()
  {
    $page = new PageModel();

    $view = new View("pagesList", "back", "Pages");
    $view->assign("page", $page);

  }
  public function pageManager()
  {
    $view = new View("pageManager", "back");

  }
  public function page()
  {
    $view = new View("page", "front");

  }
  
}