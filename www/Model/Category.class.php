<?php

namespace App\Model;

use App\Core\Sql;
use App\Core\Cleandwords;

class Category extends Sql
{
  protected $id = null;
  protected $name = null;

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

  public function setName(?string $name): void
  {
    $this->name = $name;
  }

  public function getCategoryForm(): array
  {
    return [
      "config" => [
        "method" => "POST",
        "action" => "",
        "submit" => "Ajouter / Modifier",
        "success" => "La categorie à bien été ajouté / modifié",
      ],
      'left' => [
        'Ajout d\'une categorie' => [
          "inputs" => [
            "name" => [
              "label" => "Nom de la categorie",
              "type" => "text",
              "placeholder" => "Nom de la categorie...",
              "required" => true,
              "class" => "input",
              "id" => "nameForm",
              "error" => "Pas de caractères speciaux ni d'escapes, séparez les mots par des -",
              "min" => 2,
              "max" => 92,
            ]
          ]
        ]
      ]
    ];
  }

  public function setCategoryInfo(): void
  {
    $this->setName($_POST['name']);
  } 

  public function delete($idCat)
  {
    $sql = $this->mysqlBuilder
      ->delete()
      ->where('id')
      ->getQuery();

    $option = [
      'id' => $idCat
    ];

    $this->executeQuery($sql, 0, $option);
  }
  

}
