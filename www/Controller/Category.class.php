<?php

namespace App\Controller;

use App\Core\Verificator;
use App\Core\View;
use App\Model\Article as ArticleModel;

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
      $category->getCategoryInfo($_GET['id']);
      if (!empty($_POST)) {
        // edit a category
        $formErrors = Verificator::checkForm($category->getCategoryForm(), $_POST);
        if (count($formErrors) === 0) {
          $category->setCategoryInfo();
          $registerError = $category->checkExisting('name') !== false;
          if ($registerError === false) {
            $category->edit();
            $saved = true;
            header("Location: /categories-list");
          } else {
            $formErrors[] = "Nom de catégorie déjà utilisé";
          }
        }
      }
    } else {
      if (!empty($_POST)) {
        $formErrors = Verificator::checkForm($category->getCategoryForm(), $_POST);
        if (count($formErrors) === 0) {
          $category->setCategoryInfo();
          $registerError = $category->checkExisting('name') !== false;
          if ($registerError === false) {
            $category->save();
            $saved = true;
            // redirect to categoriesList
            header("Location: /categories-list");
          } else {
            $formErrors[] = "Nom de Categorie déjà utilisé";
          }
        }
      }
    }

    $view = new View("categoryManager", "back", isset($_GET['id']) ? $category->getName() . ' - Edit' : 'New Category');
    $view->assign("category", $category);
    $view->assign("success", $saved);
    $view->assign("errors", $formErrors);
  }

  public function categoriesView()
  {
    $category = new CategoryModel();
    $categories = $category->getAll('name');
    $view = new View("categoriesview", "front", "Categories", "You can find all categories of your favorite wiki and encyclopedia here. Navigate through the categories to find the articles you are looking for.");
    $view->assign("categories", $categories);
  }

  public function categoryView()
  {
    $article = new ArticleModel();
    $articles = $article->where('category_id', $_GET['id']);
    $category = new CategoryModel();
    if (isset($_GET['id'])) {
      $category->getCategoryInfo($_GET['id']);
    } else {
      $category = null;
    }

    if (!empty($articles)) {
      foreach ($articles as $article) {
        $currentArticle = new ArticleModel();
        $currentArticle->getArticleInfo($article->id);
        $articlesList[] = $currentArticle;
      }
    }

    $view = new View("categoryview", "front", $category ? $category->getName() : "Category", "You can find all articles of the category ". $category->getName() ."  here. Navigate through the articles to find one of the category" . $category->getName() . " that piques your interest");
    $view->assign("category", $category);
    $view->assign("articles", $articlesList ?? []);
  }
}
