<?php if (isset($article) && $article !== false) : ?>
  <article>
    <h1><?= $article->getTitle() ?></h1>
    <?php if ($article->getSubtitle() && $article->getSubtitle() !== 'NULL') : ?>
      <h2 class="h2-front"><?= $article->getSubtitle() ?></h2>
    <?php endif; ?>
    <img src="<?= $article->getMediaPath() ?>" alt="<?= $article->getTitle() ?>">
    <div id="content"><?= $article->getContent() ?></div>
    <p class="end">
      Publié par <b><?= $article->getAuthorFirstname() ?> <?= $article->getAuthorLastname() ?></b> dans <?= $article->getCategoryName() ?> le <?= $article->getArticleCreationDate() ?>.<br>
      Vue <?= $article->getClickedOn() ?> fois.
    </p>
  </article>

  <hr style="width: 100%;">

  <div class="comments">
    <h2>Commentaires</h2>
    <?php if (isset($comments) && !empty($comments)) : ?>
      <?php foreach ($comments as $comment) : ?>
        <div class="comment">
          <p><?= $comment->getContent() ?></p>
          <p class="end">
            Commenté par <b><?= $comment->getAuthorFirstname() ?> <?= $comment->getAuthorLastname() ?></b> le <?= $comment->getCreatedAt() ?>.<br>
            <?php if ($comment->getUserId() === $userInfos['id']) : ?>
              <a href="/article?id=<?= $article->getId() ?>&deletedId=<?= $comment->getId() ?>">
                Supprimer
              </a>
            <?php endif; ?>
            <?php if ($comment->getUserId() !== $userInfos['id']) : ?>
              <a class="link-report" href="/article?id=<?= $article->getId() ?>&signalId=<?= $comment->getId() ?>">
                Signaler
              </a>
            <?php endif; ?>
          </p>
        </div>
      <?php endforeach; ?>
    <?php else : ?>
      <p>Aucun commentaire n'a été posté pour l'instant.</p>
    <?php endif; ?>

    <h2>Ajouter un commentaire</h2>
    <?php if ($isAuth) : ?>
      <?php $this->includePartial("form", $comment->getForm()) ?>
    <?php else : ?>
      <p>Vous devez être connecté pour pouvoir commenter.</p>
    <?php endif; ?>
  </div>

<?php else : ?>
  <h1>400 - Bad request</h1>
  <h3>Désolé, je ne sais pas comment vous avez atterri ici 🤷‍♂️</h3>
  <a class="button button--secondary" href="/">Revenir à l'acceuil</a>
<?php endif; ?>