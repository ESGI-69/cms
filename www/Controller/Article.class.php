<?php

namespace App\Controller;

use App\Core\View;
use App\Model\Article as ArticleModel;

class Article
{

  public function articlesList()
  {
    $view = new View("articlesList", "back", "Articles");
  }

  public function articleManager()
  {
    $success = false;
    $article = new ArticleModel();
    $view = new View("articleManager", "back", isset($_GET['id']) ? 'ARTICLE NAME - Edit' : 'New Article');
    $view->assign('article', $article);
    $view->assign('success', $success);
  }

  public function article()
  {
    $view = new View("article", "front", "Article");
  }
}
