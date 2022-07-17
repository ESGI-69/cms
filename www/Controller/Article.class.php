<?php

namespace App\Controller;

use App\Core\View;
use App\Core\Logger;
use App\Core\Verificator;
use App\Core\AuthManager;
use App\Model\Article as ArticleModel;
use App\Model\Comment as CommentModel;

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
          $registerError = $article->checkExisting('title') !== false;
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
      $auth = new AuthManager();
      $article = new ArticleModel();
      $log = Logger::getInstance();
      $articleInfos = $article->getArticleInfo($_GET['id']);

      if (empty($articleInfos)) {
        header("Location: /");
      } else {
        if (strlen($article->getsubtitle()) >= 100) {
          $description = substr($article->getsubtitle(), 0, 165) . "...";
        } else if (strlen($article->getsubtitle()) > 50) {
          $description = $article->getsubtitle() . " " . substr(strip_tags($article->getContent()), 0, 65) . "...";
        } else {
          $description = $article->getsubtitle() . " " . substr(strip_tags($article->getContent()), 0, 115) . "...";
        }
        $comment = new CommentModel();

        // Suppresion d'un commentaire
        if (isset($_GET['deletedId'])) {
          $comment->getCommentInfo($_GET['deletedId']);
          if ($auth->userInfos()['id'] === $comment->getUserId()) {
            $log->add("comment", "Comment '" . $comment->getContent() . "' (" . $comment->getId() . ") deleted by user n." . $comment->getUserId() . "!");
            $comment->delete($_GET['deletedId']);
          }
        }

        // get all article comments
        $comments = $comment->where('article_id', $_GET['id']);
        if (!empty($comments)) {
          foreach ($comments as $comment) {
            $currentComment = new CommentModel();
            $currentComment->getCommentInfo($comment->id);
            $commentsList[] = $currentComment;
          }
        }

        if (!empty($_POST)) {
          $comment = new CommentModel();
          $success = false;
          $formErrors = Verificator::checkForm($comment->getForm(), $_POST);
          if (count($formErrors) === 0) {
            $comment->setContent($_POST['content']);
            $comment->setArticleId($_GET['id']);
            $comment->setUserId($auth->userInfos()['id']);
            $comment->save();
            $success = true;
            $log->add("comment", "Comment '" . $article->getContent() . "' created by user n." . $article->getAuthor() . " on article n." . $article->getId() . "!");
            header("Location: /article?id=" . $_GET['id']);
          }
        }

        $article->incrementView(intval($_GET['id']), ['clickedOn']);
        $articleInfos = $article->getArticleInfo($_GET['id']);
        $articleMedia = $article->getJoin($article->getId(), 'wk_media', 'media_id', 'id');
        $view = new View("article", "front", $article->getTitle(), $description);
        $view->assign('article', $article);
        $view->assign('articleMedia', $articleMedia);
        $view->assign("comments", $commentsList ?? []);
        $view->assign("comment", $comment);
        $view->assign('errors', $formErrors ?? []);
        $view->assign('success', $success ?? false);
      }
    } else {
      $view = new View("article", "front", "Article");
    }
  }
}
