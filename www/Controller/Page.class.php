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

    if (isset($_GET['deletedId'])) {
      $page->delete($_GET['deletedId']);
    }

    $this->pages = $page->getAll();

    $view = new View("pagesList", "back", "Pages");
    $view->assign("page", $page);
    $view->assign("pages", $this->pages);

  }
  public function pageManager()
  {
    $page = new PageModel();
    $saved = false;
    $formErrors = [];
    $registerError = false;

    // à faire
    if (isset($_GET['id'])) {
      // $this->editMedia($_GET['editId']);
    } else {
      if (!empty($_POST)) {
        echo "test";
        $formErrors = Verificator::checkForm($page->getPageForm(), $_POST);
        if (count($formErrors) === 0) {
          $page->setPageInfo();
          $registerError = $page->checkExisting('title');
          if ($registerError === false) {
            $page->savePage();
            $saved = true;
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