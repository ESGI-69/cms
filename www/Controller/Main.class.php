<?php

namespace App\Controller;

use App\Core\View;
use App\Model\Component as Component;
use App\Model\Article as ArticleModel;
use App\Model\Page as PageModel;
use App\Model\Category as CategoryModel;

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


    $descDefault = "Welcome on wikiki, one of the best wiki and encyclopedia site in the world! Here you can find the best articles with rocks facts and more! Ours articles are verified and without fake news !";

    $view = new View("home", "front", null, $descDefault);
    $view->assign("articles", $articlesList);
  }

  public function sitemap()
  {
    header("Content-Type: text/xml");
    $article = new ArticleModel();
    $articles = $article->getAll();
    $page = new PageModel();
    $pages = $page->getAll();
    $category = new CategoryModel();
    $categories = $category->getAll();

    // Parse the routes.yaml file
    $routes = yaml_parse_file(__DIR__ . "/../routes.yml");

    $view = new View("sitemap", "none");
    $view->assign("articles", $articles);
    $view->assign("pages", $pages);
    $view->assign("categories", $categories);
    $view->assign("staticUrls", $routes);
  }

  public static function sidebarFront(): array
  {
    $sidebar = new Component();
    $sidebarId = $sidebar->getWhere("wk_navigation", "value", "navbar");
    $sidebarElements = $sidebar->getNoModel("navigation_id", $sidebarId, "wk_page");
    return $sidebarElements;
  }


  public static function footer(): array
  {
    $footer = new Component();
    $footerId = $footer->getWhere("wk_navigation", "value", "footer");
    $footerElements = $footer->getNoModel("navigation_id", $footerId, "wk_page");

    return $footerElements;
  }

}
