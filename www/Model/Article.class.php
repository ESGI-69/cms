<?php

namespace App\Model;

use App\Core\Sql;

class Article extends Sql
{
  protected $id = null;

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
            "image" => [
              "label" => "Image",
              "type" => "media",
              "medias" => $medias,
              "required" => true,
              "id" => "image",
              "unicity" => "true",
              "errorUnicity" => "Le titre doit être unique",
            ],
            "content" => [
              "label" => "Contenu",
              "type" => "wysiwyg",
              "placeholder" => "The cat (Felis catus) is a domestic species of small carnivorous mammal. It is the only domesticated species in the family Felidae and is often referred to as the domestic cat to distinguish it from the wild members of the family. A cat can either be a house cat, a farm cat or a feral cat; the latter ranges freely and avoids human contact. Domestic cats are valued by humans for companionship and their ability to kill rodents. About 60 cat breeds are recognized by various cat registries.",
              "required" => true,
              "error" => "Un article se doit d'avois un contenu.",
            ],
          ]
        ],
      ],
      'right' => [
        'Informations complémentaires' => [
          'inputs' => [
            "category" => [
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
            "author" => [
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
}
