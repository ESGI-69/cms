<?php

namespace App\Model;

use App\Core\Sql;

class Article extends Sql
{
  protected $id = null;
  protected $title = null;
  protected $subtitle = null;
  protected $media_id = null;
  protected $content = null;
  protected $user_id = null;
  protected $category_id = null;
  protected $createdAt = null;
  protected $updatedAt = null;
  protected $clickedOn = 0;

  public function __construct()
  {
    parent::__construct();
  }

  protected function setId($id)
  {
    $this->id = $id;
  }

  /**
   * @return null|int
   */
  public function getId(): ?int
  {
    return $this->id;
  }

  public function setTitle(?string $title): void
  {
    $this->title = htmlspecialchars(trim($title), ENT_COMPAT);
  }

  public function getTitle(): ?string
  {
    return $this->title;
  }

  public function getClickedOn(): int
  {
    return $this->clickedOn;
  }

  public function setClickedOn(int $clickedOn): void
  {
    $this->clickedOn = $clickedOn;
  }

  public function setSubtitle(?string $subtitle): void
  {
    $this->subtitle = htmlspecialchars(trim($subtitle), ENT_COMPAT);
  }

  public function getSubtitle(): ?string
  {
    return $this->subtitle;
  }

  public function setMedia(?string $media_id): void
  {
    $this->media_id = htmlspecialchars(trim($media_id), ENT_COMPAT);
  }

  public function getMedia(): ?string
  {
    return $this->media_id;
  }

  public function getMediaPath(): ?string
  {
    return $this->getJoin($this->getId(), 'wk_media', 'media_id', 'id')[0]->path;
  }

  public function setContent(?string $content): void
  {
    $this->content = htmlspecialchars(trim($content), ENT_COMPAT);
  }

  public function getContent(): ?string
  {
    return html_entity_decode(html_entity_decode($this->content));
  }

  public function getShortedContent(): ?string
  {
    return substr(strip_tags($this->getContent()), 0, 256);
  }

  public function setAuthor(?string $user_id): void
  {
    $this->user_id = htmlspecialchars(trim($user_id), ENT_COMPAT);
  }

  public function getAuthor(): ?string
  {
    return $this->user_id;
  }

  public function getAuthorFirstname(): string
  {
    return $this->getJoin($this->getId(), 'wk_user', 'user_id', 'id')[0]->firstname;
  }

  public function getAuthorLastname(): string
  {
    return $this->getJoin($this->getId(), 'wk_user', 'user_id', 'id')[0]->lastname;
  }

  public function getAuthorEmail(): string
  {
    return $this->getJoin($this->getId(), 'wk_user', 'user_id', 'id')[0]->email;
  }

  public function setCategory(?string $category_id): void
  {
    $this->category_id = htmlspecialchars(trim($category_id), ENT_COMPAT);
  }

  public function getCategory(): ?string
  {
    return $this->category_id;
  }

  public function getCategoryName(): string
  {
    return $this->getJoin($this->getId(), 'wk_category', 'category_id', 'id')[0]->name;
  }

  public function getArticleCreationDate(): string
  {
    return $this->createdAt;
  }

  public function getArticleUpdateDate()
  {
    return $this->updatedAt;
  }

  public function getArticleInfo(?string $id): array
  {
    $this->setId($id);
    $result = $this->get($this->getId());
    if (isset($result) && $result !== false) {
      $media = $this->getJoin($result->id, 'wk_media', 'media_id', 'id')[0]->id;
      $author = $this->getJoin($result->id, 'wk_user', 'user_id', 'id')[0]->id;
      $category = $this->getJoin($result->id, 'wk_category', 'category_id', 'id')[0]->id;
      $this->setTitle($result->title);
      $this->setSubtitle($result->subtitle);
      $this->setClickedOn($result->clickedOn);
      $this->setMedia($media);
      $this->setContent($result->content);
      $this->setAuthor($author);
      $this->setCategory($category);
      $this->createdAt = $result->createdAt;
      $this->updatedAt = $result->updatedAt;
      return [
        'id' => $this->getId(),
        'title' => $this->getTitle(),
        'subtitle' => $this->getSubtitle(),
        'media' => $this->getMedia(),
        'content' => $this->getContent(),
        'author' => $this->getAuthor(),
        'category' => $this->getCategory(),
        'createdAt' => $this->getArticleCreationDate(),
        'updatedAt' => $this->getArticleUpdateDate(),
      ];
    } else {
      return [];
    }
  }

  public function getForm(): array
  {
    $category = new Category();
    $categories = $category->getAll();

    $user = new User();
    $adminUsers = $user->getAllAdmins();

    $media = new Media();
    $medias = $media->getAll();

    return [
      "config" => [
        "method" => "POST",
        "action" => "",
        "submit" => empty($this->getId()) ? "Créer l'article" : "Modifier l'article",
        "success" => "L'article a bien été créé !",
      ],
      'left' => [
        "Informations Principales" => [
          'inputs' => [
            "title" => [
              "value" => $this->getTitle() ? $this->getTitle() : "",
              "label" => "Titre",
              "type" => "text",
              "placeholder" => "Chat",
              "required" => true,
              "class" => "input",
              "id" => "title",
              "error" => "Titre invalide",
              "unicity" => "true",
              "errorUnicity" => "Le titre doit être unique",
            ],
            "subtitle" => [
              "value" => $this->getSubtitle() ? $this->getSubtitle() : "",
              "label" => "Sous-titre",
              "type" => "text",
              "placeholder" => "Sous-espèce issue de la domestication du Chat sauvage",
              "required" => false,
              "class" => "input",
              "id" => "subtitle",
              "error" => "Sous-titre invalide",
            ],
            "media_id" => [
              "value" => $this->getMedia() ? $this->getMedia() : "",
              "label" => "Image",
              "type" => "media",
              "medias" => $medias,
              "required" => true,
              "id" => "image",
            ],
            "content" => [
              "value" => $this->getContent() ? $this->getContent() : "",
              "label" => "Contenu",
              "type" => "wysiwyg",
              "id" => "wysiwyg",
              "placeholder" => "Il est l’un des principaux animaux de compagnie et compte aujourd’hui une cinquantaine de races différentes reconnues par les instances de certification. Dans de très nombreux pays, le chat entre dans le cadre de la législation sur les carnivores domestiques à l’instar du chien et du furet. Essentiellement territorial, le chat est un prédateur de petites proies comme les rongeurs ou les oiseaux.",
              "required" => true,
              "error" => "Un article se doit d'avoir un contenu.",
            ],
          ]
        ],
      ],
      'right' => [
        'Informations complémentaires' => [
          'inputs' => [
            "category_id" => [
              "selected" => $this->getCategory() ? $this->getCategory() : "",
              "label" => "Catégorie",
              "type" => "select",
              "options" => $categories,
              "valueKey" => "id",
              "labelKey" => "name",
              "required" => true,
              "class" => "input",
              "id" => "category",
              "error" => "Catégorie invalide",
            ],
            "user_id" => [
              "selected" => $this->getAuthor() ? $this->getAuthor() : "",
              "label" => "Auteur",
              "type" => "select",
              "options" => $adminUsers,
              "valueKey" => "id",
              "labelKey" => "email",
              "required" => true,
              "class" => "input",
              "id" => "pwdForm",
              "error" => "Votre mot de passe doit faire au min 8 caractères avec majuscule, minuscules et des chiffres",
            ],
          ],
        ],
      ],
    ];
  }

  public function setArticleInfo(): void
  {
    try {
      $this->setTitle($_POST['title']);
      $this->setSubtitle($_POST['subtitle']);
      $this->setMedia($_POST['media_id']);
      $this->setContent($_POST['content']);
      $this->setCategory($_POST['category_id']);
      $this->setAuthor($_POST['user_id']);
    } catch (\Exception $e) {
      echo "Impossible d'assigner les properties du Model Page";
      print_r($e);
    }
  }
}
