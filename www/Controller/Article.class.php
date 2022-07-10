<?php

namespace App\Controller;

use App\Core\View;
use App\Core\Verificator;
use App\Model\Article as ArticleModel;

class Article
{

  public function articlesList()
  {
    $article = new ArticleModel();

    if (isset($_GET['deletedId'])) {
      $article->delete($_GET['deletedId']);
    }

    $this->articles = $article->getAll();

    $view = new View("articlesList", "back", "Articles");
    $view->assign("article", $article);
    $view->assign("articles", $this->articles);
  }

  public function articleManager()
  {
    $success = false;
    $article = new ArticleModel();
    $formErrors = [];

    if (!empty($_POST)) {
      $formErrors = Verificator::checkForm($article->getForm(), $_POST);
      if (count($formErrors) === 0) {
        $article->setArticleInfo();
        $registerError = $article->checkExisting('title');
        if ($registerError === false) {
          $article->save();
          $success = true;
          header("Location: /articles-list");
        } else {
          $formErrors[] = "Titre déjà utilisé";
        }
      }
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
