<?php

namespace App\Controller;

use App\Core\View;
use App\Model\Component as Component;
use App\Model\Article as ArticleModel;
use App\Model\Page as PageModel;
use App\Model\Category as CategoryModel;
use App\Model\Install as InstallModel;
use App\Model\Meta as Meta;
use App\Model\User as UserModel;

class Main
{
  public function home()
  {
    $install = new InstallModel();
    $databaseEmpty = $install->isDatabaseEmpty();
    if ($databaseEmpty) {
      header("Location: /install");
    }

    $article = new ArticleModel();
    $articles = $article->getLast(5);

    $articlesList = [];

    foreach ($articles as $article) {
      $currentArticle = new ArticleModel();
      $currentArticle->getArticleInfo($article->id);
      $articlesList[] = $currentArticle;
    }
    $meta = new Meta();
    $descDefault = $meta->getMeta('description');

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

  public function install()
  {
    $install = new InstallModel();
    $databaseEmpty = $install->isDatabaseEmpty();
    if (!$databaseEmpty) {
      header("Location: /");
    }
?>
    <!DOCTYPE html>
    <html lang="fr">

    <head>
      <title>Wikiki - Installation</title>
      <link rel="stylesheet" href="/css/index.css">
    </head>

    <body class="install">
      <?php
      if (!empty($_POST) && $databaseEmpty) {
        if ($_POST["password"] === $_POST["passwordConfirm"]) {
          $install->initializeDatabase();
          $user = new UserModel();
          $user->setRegisterInfo();
          $user->setId('-1');
          $user->setRole('1');
          $user->setStatus('1');
          $user->save();
          $meta = new Meta();
          $meta->setType("title");
          $meta->setValue($_POST["title"]);
          $meta->save();
          $meta->setType('description');
          $meta->setValue($_POST["description"]);
          $meta->save();
          header("Location: /");
        } else {
          $error = "Les mots de passe ne correspondent pas";
        }
      }
      ?>
      <h1>Installation</h1>
      <div class="install__container">
        <h2>Création de l'utilisateur administrateur</h2>
        <form class="install__container__form" action="" method="post">
          <label for="title">Titre du site</label>
          <input type="texte" name="title" id="title" required />
          <label for="description">Description du site (200 caractères max)</label>
          <textarea class="install-text-area" name="description" id="description" maxlength="200" required>Welcome on wikiki, one of the best wiki and encyclopedia site in the world! Here you can find the best articles with rocks facts ! Ours articles are verified and without fake news !</textarea>
          <label for="email">Email</label>
          <input type="email" name="email" id="email" required/>
          <label for="password">Mot de passe</label>
          <input type="password" name="password" id="password" required />
          <label for="passwordConfirm">Confirmation du mot de passe</label>
          <input type="password" name="passwordConfirm" id="passwordConfirm" required />
          <label for="firstname">Prénom</label>
          <input type="text" name="firstname" id="firstname" required />
          <label for="lastname">Nom de Famille</label>
          <input type="text" name="lastname" id="lastname" required />
          <button class="button" type="submit" value="Install">
            Créer l'administrateur et commencer à utiliser wikiki
          </button>
          <?php if (isset($error)) : ?>
            <p class="error">
              <?= $error ?>
            </p>
          <?php endif; ?>
        </form>
      </div>
    </body>
    <style>
      .install-text-area{
        width: 500px;
        max-width: 500px;
        min-height: 100px;
        max-height: 200px;
      }
    </style>
  </html>
<?php
  }
}
