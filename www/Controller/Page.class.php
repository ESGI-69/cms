<?php

namespace App\Controller;

use App\Core\CleanWords;
use App\Core\Sql;
use App\Core\Verificator;
use App\Core\View;
use App\Core\Logger;

use App\Model\Page as PageModel;

class Page
{
  public function pagesList()
  {
    $log = Logger::getInstance();
    $page = new PageModel();

    if (isset($_GET['deletedId'])) {
      $page->getPageInfo($_GET['deletedId']);
      $log->add("page", "Page '" . $page->getTitle() . "' edited by user n." . $page->getUserId() . "!");
      $page->delete($_GET['deletedId']);
    }

    $this->pages = $page->getAll();

    $view = new View("pagesList", "back", "Pages");
    $view->assign("page", $page);
    $view->assign("pages", $this->pages);
  }
  public function pageManager()
  {
    $log = Logger::getInstance();
    $page = new PageModel();
    $saved = false;
    $formErrors = [];
    $registerError = false;

    if (isset($_GET['id'])) {
      $page->getPageInfo($_GET['id']);
      if (!empty($_POST)) {
        $formErrors = Verificator::checkForm($page->getPageForm(), $_POST);
        if (count($formErrors) === 0) {
          $page->setPageInfo();
          if ($registerError === false) {
            $page->edit();
            $saved = true;
            $log->add("page", "Page '" . $page->getTitle() . "' edited by user n." . $page->getUserId() . "!");
            header("Location: /pages-list");
          } else {
            $formErrors[] = "Nom de page déjà utilisé";
          }
        }
      }
    } else {
      if (!empty($_POST)) {
        $formErrors = Verificator::checkForm($page->getPageForm(), $_POST);
        if (count($formErrors) === 0) {
          $page->setPageInfo();
          $registerError = $page->checkExisting('title');
          if ($registerError === false) {
            $page->save();
            $saved = true;
            $log->add("page", "Page '" . $page->getTitle() . "' created by user n." . " $page->getUserId " . "!");
            header("Location: /pages-list");
          } else {
            $formErrors[] = "Nom de page déjà utilisé";
          }
        }
      }
    }


    $view = new View("pageManager", "back", "New page");
    $view->assign("page", $page);
    $view->assign("success", $saved);
    $view->assign("errors", $formErrors);
  }
  public function page()
  {
    $view = new View("page", "front");
  }
}
