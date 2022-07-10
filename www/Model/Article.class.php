<?php

namespace App\Model;

use App\Core\Sql;

class Article extends Sql
{
  protected $id = null;
  protected $title = null;
  protected $media_id = null;
  protected $content = null;
  protected $user_id = null;
  protected $category_id = null;

  public function __construct()
  {
    parent::__construct();
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

  public function setMedia(?string $media_id): void
  {
    $this->media_id = htmlspecialchars(trim($media_id), ENT_COMPAT);
  }

  public function getMedia(): ?string
  {
    return $this->media_id;
  }

  public function setContent(?string $content): void
  {
    $this->content = htmlspecialchars(trim($content), ENT_COMPAT);
  }

  public function getContent(): ?string
  {
    return $this->content;
  }

  public function setAuthor(?string $user_id): void
  {
    $this->user_id = htmlspecialchars(trim($user_id), ENT_COMPAT);
  }

  public function getAuthor(): ?string
  {
    return $this->user_id;
  }

  public function setCategory(?string $category_id): void
  {
    $this->category_id = htmlspecialchars(trim($category_id), ENT_COMPAT);
  }

  public function getCategory(): ?string
  {
    return $this->category_id;
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
        "submit" => empty($this->getId()) ? "Créer la page" : "Modifier la page",
        "success" => "La page a bien été créé !",
      ],
      'left' => [
        "Informations Principales" => [
          'inputs' => [
            "title" => [
              "label" => "Titre",
              "type" => "text",
              "placeholder" => "Cat",
              "required" => true,
              "class" => "input",
              "id" => "title",
              "error" => "Titre invalide",
              "unicity" => "true",
              "errorUnicity" => "Le titre doit être unique",
            ],
            "media_id" => [
              "label" => "Image",
              "type" => "media",
              "medias" => $medias,
              "required" => true,
              "id" => "image",
            ],
            "content" => [
              "label" => "Contenu",
              "type" => "wysiwyg",
              "placeholder" => "The cat (Felis catus) is a domestic species of small carnivorous mammal. It is the only domesticated species in the family Felidae and is often referred to as the domestic cat to distinguish it from the wild members of the family. A cat can either be a house cat, a farm cat or a feral cat; the latter ranges freely and avoids human contact. Domestic cats are valued by humans for companionship and their ability to kill rodents. About 60 cat breeds are recognized by various cat registries.",
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
