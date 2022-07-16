<?php

namespace App\Controller;

use App\Core\View;
use App\Model\Footer as Footer;
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

    $view = new View("home");
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

  public static function footer(): array
  {
    $footer = new Footer();
    $footerId = $footer->getWhere("wk_navigation", "value", "footer");
    $footerElements = $footer->getNoModel("navigation_id", $footerId, "wk_page");

    return $footerElements;
  }

}
