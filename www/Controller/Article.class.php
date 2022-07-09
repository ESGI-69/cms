<?php

namespace App\Controller;

use App\Core\View;
use App\Core\Verificator;
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
    $formErrors = [];

    if (!empty($_POST)) {
      $formErrors = Verificator::checkForm($article->getForm(), $_POST);
    }

    $view = new View("articleManager", "back", isset($_GET['id']) ? 'ARTICLE NAME - Edit' : 'New Article');
    $view->assign('article', $article);
    $view->assign('errors', $formErrors);
    $view->assign('success', $success);
  }

  public function article()
  {
    $view = new View("article", "front", "Article");
  }
}
