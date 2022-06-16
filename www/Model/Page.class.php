<?php

namespace App\Model;

use App\Core\Sql;

class Page extends Sql

{
  protected $id = null;
  protected $title = null;
  protected $url = null;
  protected $content = null;
  protected $subtile = null;
  protected $user_id = null;
  protected $category_id = null;
  

  public function __construct()
  {
    parent::__construct();
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
    $this->title = trim($title);
  }

  public function getUrl(): ?string
  {
    return $this->url;
  }

  public function setUrl(?string $url): void
  {
    $this->url = str_replace(' ', '-', strtolower(trim($url)));
  }

  public function getContent(): ?string
  {
    return $this->content;
  }

  public function setContent(?string $content): void
  {
    $this->content = $content;
  }

  public function getSubtile(): ?string
  {
    return $this->subtile;
  }

  public function setSubtile(?string $subtile): void
  {
    $this->subtile = trim($subtile);
  }

  public function getUserId(): ?int
  {
    return $this->user_id;
  }

  public function setUserId(?int $user_id): void
  {
    $this->user_id = $user_id;
  }

  public function getCategoryId(): ?int
  {
    return $this->category_id;
  }

  public function setCategoryId(?int $category_id): void
  {
    $this->category_id = $category_id;
  }

  public function getPageForm(): array {
    return [
      "config" => [
        "method" => "POST",
        "action" => "",
        "submit" => "Ajouter"
      ],
      "inputs" => [
        "title" => [
          "type" => "text",
          "placeholder" => "Titre",
          "id" => "titleForm",
          "class" => "inputForm",
          "required" => true,
          "error" => "Veuillez entrer un titre",
          "min" => 2,
          "max" => 100,
        ],
        "subtitle" => [
          "type" => "text",
          "placeholder" => "Sous-titre",
          "id" => "subtitleForm",
          "class" => "inputForm",
          "required" => true,
          "error" => "Veuillez entrer un sous-titre",
          "min" => 2,
          "max" => 100,
        ],
        "image" => [
          "type" => "file",
          "placeholder" => "Image",
          "id" => "imageForm",
          "class" => "inputForm",
          "required" => true,
          "error" => "Veuillez téléverser une image",
          "accept" => ""
        ],
        "content" => [
          "type" => "wysiwyg",
          "placeholder" => "Contenu",
          "id" => "contentForm",
          "class" => "textareaForm ",
          "required" => true,
          "error" => "Veuillez entrer un contenu",
          "min" => 2,
          "max" => 10000,
        ],
      ]
    ];
  }
}
