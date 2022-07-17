<?php

namespace App\Model;

use App\Core\Sql;

class Comment extends Sql
{
  protected $id = null;
  protected $content = null;
  protected $user_id = null;
  protected $article_id = null;
  protected $createdAt = null;
  protected $updatedAt = null;

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

  public function getContent(): ?string
  {
    return html_entity_decode(html_entity_decode($this->content));
  }

  public function setContent(?string $content): void
  {
    $this->content = htmlspecialchars(trim($content), ENT_COMPAT);
  }

  public function getUserId(): ?int
  {
    return $this->user_id;
  }

  public function setUserId(?int $user_id): void
  {
    $this->user_id = $user_id;
  }

  public function getArticleId(): int
  {
    return $this->article_id;
  }

  public function setArticleId(?int $article_id): void
  {
    $this->article_id = $article_id;
  }

  public function getCreatedAt(): string
  {
    return $this->createdAt;
  }

  public function setCreatedAt(string $createdAt): void
  {
    $this->createdAt = $createdAt;
  }

  public function getUpdatedAt(): ?string
  {
    return $this->updatedAt;
  }

  public function setUpdatedAt(): void
  {
    $this->updatedAt = date('Y-m-d H:i:s');
  }

  public function getAuthorFirstname()
  {
    return $this->getJoin($this->getId(), 'wk_user', 'user_id', 'id')[0]->firstname;
  }

  public function getAuthorLastname()
  {
    return $this->getJoin($this->getId(), 'wk_user', 'user_id', 'id')[0]->lastname;
  }

  public function getCommentInfo(?string $id): array
  {
    $this->setId($id);
    $result = $this->get($this->getId());
    if (isset($result) && $result !== false) {
      $this->setContent($result->content);
      $this->setUserId($result->user_id);
      $this->setArticleId($result->article_id);
      $this->setCreatedAt($result->createdAt);
      $this->setUpdatedAt($result->updatedAt);
      return [
        'id' => $this->getId(),
        'content' => $this->getContent(),
        'user_id' => $this->getUserId(),
        'article_id' => $this->getArticleId(),
        'createdAt' => $this->getCreatedAt(),
        'updatedAt' => $this->getUpdatedAt(),
        'authorFirstname' => $this->getAuthorFirstname(),
        'authorLastname' => $this->getAuthorLastname(),
      ];
    } else {
      return [];
    }
  }

  public function getForm(): array
  {
    return [
      "config" => [
        "method" => "POST",
        "action" => "",
        "submit" => "Commenter",
        "success" => "Votre commentaire a bien été ajouté",
      ],
      "inputs" => [
        "content" => [
          "value" => "",
          "label" => "Commentaire",
          "type" => "textarea",
          "class" => "textarea-comment",
          "placeholder" => "Cet article est super !",
          "id" => "content",
          "required" => true,
          "error" => "Veuillez entrer un contenu",
          "min" => 2,
          "max" => 1000,
        ],
      ]
    ];
  }
}
