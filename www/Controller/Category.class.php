<?php
namespace App\Controller;

use App\Core\Sql;
use App\Core\Verificator;
use App\Core\View;
use App\Core\AuthManager;

use App\Model\Category as CategoryModel;

class Category
{
  public function categoriesList()
  {
    $category = new CategoryModel();

    if (isset($_GET['deletedId'])) {
      $category->delete($_GET['deletedId']);
    }

    $this->categories = $category->getAll();

    $view = new View("categoriesList", "back", "Categories");
    $view->assign("category", $category);
    $view->assign("categories", $this->categories);
  }

  public function categoryManager()
  {
    $category = new CategoryModel();
    $saved = false;
    $formErrors = [];
    $registerError = false;

    if (isset($_GET['id'])) {
      // $this->editCategory($_GET['editId']);
    } else {
      if (!empty($_POST)) {
        $formErrors = Verificator::checkForm($category->getCategoryForm(), $_POST);
        if (count($formErrors) === 0) {
          $category->setCategoryInfo();
          $registerError = $category->checkExisting('name');
          if ($registerError === false) {
            $category->saveCategory();
            $saved = true;
          } else {
            $formErrors[] = "Nom de Categorie déjà utilisé";
          }
        }
      }
    }



    $view = new View("categoryManager", "back", isset($_GET['id']) ? 'CATEGORY NAME - Edit' : 'New Category');
    $view->assign("category", $category);
    $view->assign("success", $saved);
    $view->assign("errors", $formErrors);
  }

}