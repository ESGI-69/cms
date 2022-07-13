<?php

namespace App\Controller;

use App\Core\View;
use App\Core\Logger;
use App\Core\Verificator;
use App\Model\Article as ArticleModel;

class Article
{

  public function articlesList()
  {
    $article = new ArticleModel();
    $log = Logger::getInstance();

    if (isset($_GET['deletedId'])) {
      $article->getArticleInfo($_GET['deletedId']);
      $log->add("article", "Article '" . $article->getTitle() . "' deleted by user n." . $article->getAuthor() . "!");
      $article->delete($_GET['deletedId']);
    }

    $this->articles = $article->getAll();

    $view = new View("articlesList", "back", "Articles");
    $view->assign("article", $article);
    $view->assign("articles", $this->articles);
  }

  public function articleManager()
  {
    $log = Logger::getInstance();
    $success = false;
    $article = new ArticleModel();
    $formErrors = [];
    $registerError = false;

    if (isset($_GET['id'])) {
      $article->getArticleInfo($_GET['id']);
      if (!empty($_POST)) {
        $formErrors = Verificator::checkForm($article->getForm(), $_POST);
        if (count($formErrors) === 0) {
          $article->setArticleInfo();
          if ($registerError === false) {
            $article->edit();
            $success = true;
            $log->add("article", "Article '" . $article->getTitle() . "' edited by user n." . $article->getAuthor() . "!");
            header("Location: /articles-list");
          } else {
            $formErrors[] = "Titre déjà utilisé";
          }
        }
      }
    } else {
      if (!empty($_POST)) {
        $formErrors = Verificator::checkForm($article->getForm(), $_POST);
        if (count($formErrors) === 0) {
          $article->setArticleInfo();
          $registerError = $article->checkExisting('title');
          if ($registerError === false) {
            $article->save();
            $success = true;
            $log->add("article", "Article '" . $article->getTitle() . "' created by user n." . $article->getAuthor() . "!");
            header("Location: /articles-list");
          } else {
            $formErrors[] = "Titre déjà utilisé";
          }
        }
      }
    }

    $view = new View("articleManager", "back", isset($_GET['id']) ? $article->getTitle() . ' - Edit' : 'New Article');
    $view->assign('article', $article);
    $view->assign('errors', $formErrors);
    $view->assign('success', $success);
  }

  public function frontView()
  {
    if (isset($_GET['id'])) {
      $article = new ArticleModel();
      $articleInfos = $article->getArticleInfo($_GET['id']);
      if (empty($articleInfos)) {
        header("Location: /");
      } else {
        $articleMedia = $article->getJoin($article->getId(), 'wk_media', 'media_id', 'id');
        $view = new View("article", "front", $article->getTitle());
        $view->assign('article', $article);
        $view->assign('articleMedia', $articleMedia);
      }
    } else {
      $view = new View("article", "front", "Article");
    }
  }
}
