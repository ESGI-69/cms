<?php

namespace App\Model;

use App\Core\Sql;
use App\Core\AuthManager;
use Stringable;

class Media extends Sql
{
  protected $id = null;
  protected $name = null;
  protected $path = null;
  protected $size = null;
  protected $user_id = null;

  protected $mediaType = null;
  protected $mediaRoute = "user-media/";

  public function __construct()
  {
    parent::__construct();
  }

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getName(): ?string
  {
    return $this->name;
  }

  public function setName(?string $name): void
  {
    $this->name = htmlspecialchars(mb_strimwidth(
      trim(
        preg_replace('/-+/', '-', preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', strtolower($name)))),
        '-'
      ),
      0,
      92
    ) . "-" . date('y-m-d'), ENT_COMPAT);
  }

  public function getMediaType(): ?string
  {
    return $this->mediaType;
  }

  public function setMediaType(?string $mediaType): void
  {
    $this->mediaType = str_replace('/', '', strstr($mediaType, '/'));
  }

  public function getPath(): ?string
  {
    return $this->path;
  }

  public function setPath($type): void
  {
    $this->path = $this->mediaRoute . $this->name . "." . $type;
  }

  public function getSize(): ?int
  {
    return $this->size;
  }

  public function setSize(?int $size): void
  {
    $this->size = $size;
  }

  public function getUserId(): ?int
  {
    return $this->user_id;
  }

  public function setUserId(): void
  {
    $this->user_id = AuthManager::userInfos()['id'];
  }

  public function getMediaForm(): array
  {
    return [
      "config" => [
        "method" => "POST",
        "action" => "",
        "submit" => "Ajouter / Modifier",
        "success" => "Le média à bien été ajouté / modifié",
        "enctype" => "multipart/form-data"
      ],
      'left' => [
        'Ajout d\'un média' => [
          "inputs" => [
            "name" => [
              "value" => $this->getName() || "",
              "label" => "Nom du média",
              "type" => "text",
              "placeholder" => "Nom du média...",
              "required" => true,
              "class" => "input",
              "id" => "nameForm",
              "error" => "Pas de caractères speciaux ni d'escapes, séparez les mots par des -",
              "min" => 2,
              "max" => 92,
            ],
            "media" => [
              "label" => "Média",
              "type" => "file",
              "placeholder" => "Téléverse une image",
              "class" => "input",
              "id" => "mediaForm",
              "error" => "Une image stp",
              "accept" => "image/*",
              "required" => true,
            ],
          ]
        ]
      ]
    ];
  }

  public function setMediaInfo(): void
  {
    try {
      $this->setName($_POST['name']);
      $this->setSize($_FILES["media"]['size']);
      $this->setMediaType($_FILES["media"]['type']);
      $this->setPath($this->getMediaType());
      $this->setUserId();
    } catch (Exception $e) {
      echo "Impossible d'assigner les properties du Model Media";
      print_r($e);
    }
  }
}
