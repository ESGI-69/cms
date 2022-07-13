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

    $articlesList = [];

    foreach ($articles as $article) {
      $currentArticle = new ArticleModel();
      $currentArticle->getArticleInfo($article->id);
      $articlesList[] = $currentArticle;
    }

    $view = new View("home");
    $view->assign("articles", $articlesList);
  }


  public function contact()
  {
    $view = new View("contact");
  }
}
