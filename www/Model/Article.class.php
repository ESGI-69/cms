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

  public function getFrom(int $sectionQuantity, int $additionalSectionQuantity): array
  {
    $category = new Category();
    $categories = $category->getAll();

    $user = new User();
    $adminUsers = $user->getAllAdmins();

    // Sections creation

    $sections = [];

    for ($sectionIndex = 0; $sectionIndex < $sectionQuantity; $sectionIndex++) {
      foreach ($this->getSectionFormInputs($sectionIndex + 1) as $sectionName => $section) {
        $sections[$sectionName] = $section;
      }
    }

    // Additionnal section creation

    $additionalSections = [];

    for ($additionalSectionIndex = 0; $additionalSectionIndex < $additionalSectionQuantity; $additionalSectionIndex++) {
      foreach ($this->getAdditionalSectionFormInputs($additionalSectionIndex + 1) as $additionalSectionName => $additionalSection) {
        $additionalSections[$additionalSectionName] = $additionalSection;
      }
    }

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
            "content" => [
              "label" => "Contenu",
              "type" => "wysiwyg",
              "placeholder" => "The cat (Felis catus) is a domestic species of small carnivorous mammal. It is the only domesticated species in the family Felidae and is often referred to as the domestic cat to distinguish it from the wild members of the family. A cat can either be a house cat, a farm cat or a feral cat; the latter ranges freely and avoids human contact. Domestic cats are valued by humans for companionship and their ability to kill rodents. About 60 cat breeds are recognized by various cat registries.",
              "required" => true,
              "error" => "Un article se doit d'avois un contenu.",
            ],
          ]
        ],
        "Séctions" => [
          'inputs' => $sections,
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
        'Séctions somplémentaires' => [
          'inputs' => $additionalSections,
        ],
      ],
    ];
  }

  public function getSectionFormInputs(int $index): array
  {
    return [
      "title-$index" => [
        "label" => "Titre de la section $index",
        "type" => "text",
        "placeholder" => "Section $index title",
        "required" => true,
        "class" => "input",
        "id" => "section-title-$index",
        "error" => "Titre de la section $index invalide",
      ],
      "content-$index" => [
        "label" => "Contenu de la section $index",
        "type" => "wysiwyg",
        "placeholder" => "The cat (Felis catus) is a domestic species of small carnivorous mammal. It is the only domesticated species in the family Felidae and is often referred to as the domestic cat to distinguish it from the wild members of the family. A cat can either be a house cat, a farm cat or a feral cat; the latter ranges freely and avoids human contact. Domestic cats are valued by humans for companionship and their ability to kill rodents. About 60 cat breeds are recognized by various cat registries.",
        "required" => true,
        "class" => "content left-padding",
        "input-label-group-additional-class" => "left-padding",
        "error" => "Votre mot de passe doit faire au min 8 caractères avec majuscule, minuscules et des chiffres",
      ],
    ];
  }

  public function getAdditionalSectionFormInputs(int $index): array
  {
    return [
      "additional-key-$index" => [
        "label" => "Titre $index",
        "type" => "input",
        "class" => "input",
        "placeholder" => "Titre $index",
        "required" => true,
        "error" => "Le title ne doit pas être vide",
      ],
      "additional-value-$index" => [
        "label" => "Valeur $index",
        "type" => "input",
        "class" => "input",
        "placeholder" => "Valeur $index",
        "required" => true,
        "error" => "La valeur ne doit pas être vide",
      ],
    ];
  }
}
