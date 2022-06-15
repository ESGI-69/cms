<?php

namespace App\Core;

use App\Core\AuthManager;

class View
{
  private $view;
  private $template;
  private $data = [];
  private $pageDescription = null;
  private $pageTitle = 'Wikiki';

  public function __construct(
    string $view,
    string $template = null,
    string $pageTitle = null,
    string $pageDescription = null
  ) {
    if ($pageTitle !== null) {
      $this->pageTitle = $this->pageTitle . ' - ' . $pageTitle;
    }
    if ($pageDescription !== null) {
      $this->pageDescription = $this->pageDescription . ' - ' . $pageDescription;
    }
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
    extract($this->data);
    include "View/" . $this->template . ".tpl.php";
  }
}
