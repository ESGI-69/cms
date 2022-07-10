<?php

namespace App\Model;

use App\Core\Sql;
use App\Core\AuthManager;

class Page extends Sql

{
  protected $id = null;
  protected $title = null;
  protected $url = null;
  protected $content = null;
  protected $subtile = null;
  protected $user_id = null;
  protected $navigation = null;
  protected $category_id = null;


  public function __construct()
  {
    parent::__construct();
  }

  protected function setId($id)
  {
    $this->id = $id;
  }

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getTitle(): ?string
  {
    return $this->title;
  }

  public function setTitle(?string $title): void
  {
    $this->title = htmlspecialchars(trim($title), ENT_COMPAT);
  }

  public function getUrl(): ?string
  {
    return $this->url;
  }

  public function setUrl(?string $url): void
  {
    $this->url = mb_strimwidth(
      trim(
        preg_replace('/-+/', '-', preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', strtolower($url)))),
        '-'
      ),
      0,
      92
    ) . "-" . date('y-m-d');
  }

  public function getContent(): ?string
  {
    return $this->content;
  }

  public function setContent(?string $content): void
  {
    $this->content = htmlspecialchars($content, ENT_COMPAT);
  }

  public function getSubtile(): ?string
  {
    return $this->subtile;
  }

  public function setSubtile(?string $subtile): void
  {
    $this->subtile = htmlspecialchars(trim($subtile), ENT_COMPAT);
  }

  public function getUserId(): ?int
  {
    return $this->user_id;
  }

  public function setUserId(): void
  {
    $this->user_id = AuthManager::userInfos()['id'];
  }

  public function getNavigation(): ?int
  {
    return $this->navigation;
  }

  public function setNavigation(?int $navigation): void
  {
    $this->navigation = $navigation;
  }

  public function getPageInfo(?string $id): array
  {
    $this->id = $id;
    $result = $this->get($id);
    if (isset($result)) {
      $navigation = $this->getJoin($result->id, 'wk_navigation', 'navigation_id', 'id');
      $navigationValue = 0;
      if ($navigation[0]->value === 'footer' ){
        $navigationValue = 1;
      } elseif ($navigation[0]->value === 'navbar') {
        $navigationValue = 2;
      }
      $this->setId($result->id);
      $this->setTitle($result->title);
      $this->setUrl($result->url);
      $this->setContent($result->content);
      $this->setSubtile($result->subtitle);
      $this->setUserId($result->user_id);
      $this->setNavigation($navigationValue);
      return [
        'id' => $this->getId(),
        'title' => $this->gettitle(),
        'url' => $this->getUrl(),
        'content' => $this->getContent(),
        'subtitle' => $this->getSubtile(),
        'user_id' => $this->getUserId(),
        'navigation' => $this->getNavigation(),
      ];
    }
  }

  public function getPageForm(): array
  {
    $navigation = new Navigation();
    $navigations = $navigation->getAll();

    return [
      "config" => [
        "method" => "POST",
        "action" => "",
        "submit" => "Ajouter",
        "success" => "Page ajoutée avec succès",
      ],
      'left' => [
        'Adding a page' => [
          "inputs" => [
            "title" => [
              "value" => $this->getTitle() ? $this->getTitle() : "",
              "label" => "Title",
              "type" => "text",
              "placeholder" => "Title",
              "id" => "titleForm",
              "class" => "input",
              "required" => true,
              "error" => "Veuillez entrer un titre",
              "min" => 2,
              "max" => 100,
            ],
            "subtitle" => [
              "value" => $this->getSubtile() ? $this->getSubtile() : "",
              "label" => "Subtitle",
              "type" => "text",
              "placeholder" => "Sous-titre",
              "id" => "subtitleForm",
              "class" => "input",
              "required" => true,
              "error" => "Veuillez entrer un sous-titre",
              "min" => 2,
              "max" => 100,
            ],
            "content" => [
              "value" => $this->getContent() ? $this->getContent() : "",
              "label" => "Content",
              "type" => "wysiwyg",
              "placeholder" => "Content",
              "id" => "contentForm",
              "class" => "textareaForm ",
              "required" => true,
              "error" => "Veuillez entrer un contenu",
              "min" => 2,
              "max" => 10000,
            ],
          ]
        ],
      ],
      'right' => [
        'Informations complémentaires' => [
          'inputs' => [
            "navigation" => [
              "label" => "Navigation",
              "type" => "select",
              "placeholder" => "Naviation",
              "id" => "selectForm",
              "valueKey" => "value",
              "labelKey" => "name",
              "options" => $navigations,
              "selected" => $this->getNavigation() ? $this->getNavigation() : "",
              "class" => "input",
              "required" => true,
              "error" => "Veuillez téléverser une image",
              "accept" => ""
            ],
          ],
        ],
      ],
    ];
  }
  public function setPageInfo(): void
  {
    try {
      $this->setTitle($_POST['title']);
      $this->setUrl($_POST['title']);
      $this->setContent($_POST['content']);
      $this->setSubtile($_POST['subtitle']);
      $this->setUserId();
      $this->setNavigation($_POST['navigation']);
    } catch (\Exception $e) {
      echo "Impossible d'assigner les properties du Model Page";
      print_r($e);
    }
  }
}
