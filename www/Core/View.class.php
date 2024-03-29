<?php

namespace App\Core;

use App\Core\AuthManager;
use App\Controller\Main;
use App\Model\Meta;

class View
{
  private $view;
  private $template;
  private $data = [];
  private $pageDescription = null;
  private $pageTitle = 'Wikiki';
  private $shortedPageTitle;

  public function __construct(
    string $view,
    string $template = 'front',
    string $pageTitle = null,
    string $pageDescription = null
  ) {
    if ($pageTitle !== null) {
      $this->shortedPageTitle = $pageTitle;
      $this->pageTitle = $this->pageTitle . ' - ' . $pageTitle;
    }
    if ($pageDescription !== null) {
      $this->pageDescription = $pageDescription;
    }
    $this->setPageTitle();
    $this->setView($view);
    $this->setTemplate($template);
  }

  public function setView($view): void
  {
    $this->view = strtolower($view);
  }

  public function setTemplate($template): void
  {
    $this->template = strtolower($template);
  }

  public function setPageTitle(): void
  {
    $meta = new Meta();
    $this->pageTitle = $meta->getMeta('title');
  }


  public function __toString(): string
  {
    return "La vue est : " . $this->view;
  }

  public function includePartial($partial, $data): void
  {
    if (!file_exists("View/Partial/" . $partial . ".partial.php")) {
      die("Le partial " . $partial . " n'existe pas");
    }

    // Genrate the csrf token
    $_SESSION['csrf_token'] = md5(uniqid(mt_rand(), true));

    $this->assign('template', $this->template);
    extract($this->data);
    include "View/Partial/" . $partial . ".partial.php";
  }

  public function assign($key, $value): void
  {
    $this->data[$key] = $value;
  }

  public function __destruct()
  {
    //array("pseudo"=>"Prof") ---> $pseudo = "Prof";
    // Include the isAuth function
    $this->data['isAuth'] = AuthManager::isAuth();
    $this->data['userInfos'] = AuthManager::userInfos();
    $this->data['isAdmin'] = AuthManager::isAdmin();
    $this->data['isMod'] = AuthManager::isMod();
    $this->data['isUser'] = AuthManager::isUser();
    $this->data['pageTitle'] = $this->pageTitle;
    $this->data['pageDescription'] = $this->pageDescription;
    $this->data['footer'] = Main::footer();
    $this->data['sidebarFront'] = Main::sidebarFront();
    $meta = new Meta();
    $this->data['websiteTitle'] = $meta->getMeta('title');
    extract($this->data);
    include "View/" . $this->template . ".tpl.php";
  }
}
