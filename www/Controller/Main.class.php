<?php

namespace App\Controller;

use App\Core\View;
use App\Model\Article as ArticleModel;

class Main
{

  public function home()
  {
    $article = new ArticleModel();
    $articles = $article->getLast(5);

    $view = new View("home");
    $view->assign("articles", $articles);
  }


  public function contact()
  {
    $view = new View("contact");
  }
}
