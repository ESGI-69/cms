<?php

namespace App\Controller;

use App\Core\Sql;
use App\Core\View;

class Admin extends Sql
{
  public function __construct()
  {
    parent::__construct();
  }

  public function dashboard()
  {
    $numberContents = [
      [
        "number" => $this->countRows('wk_user'),
        "name" => "Users",

      ],
      [
        "number" => $this->countRows('wk_page'),
        "name" => "Pages",
      ],
      [
        "number" => $this->countRows('wk_article'),
        "name" => "Articles",
      ],
      [
        "number" => $this->countRows('wk_media'),
        "name" => "Medias",
      ],
      [
        "number" => $this->countRows('wk_category'),
        "name" => "Categories",
      ],
    ];


    $view = new View("dashboard", "back", "Dashboard");
    $view->assign("numberContents", $numberContents);
  }
}
