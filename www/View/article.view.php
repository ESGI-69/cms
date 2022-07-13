<?php if (isset($article) && $article !== false) : ?>
  <article>
    <h1><?= $article->getTitle() ?></h1>
    <?php if ($article->getSubtitle() && $article->getSubtitle() !== 'NULL') : ?>
      <h4><?= $article->getSubtitle() ?></h4>
    <?php endif; ?>
    <img src="<?= $article->getMediaPath() ?>" alt="<?= $article->getTitle() ?>">
    <div id="content"><?= $article->getContent() ?></div>
    <p class="end">
      Publié par <b><?= $article->getAuthorFirstname() ?> <?= $article->getAuthorLastname() ?></b> dans <?= $article->getCategoryName() ?> le <?= $article->getArticleCreationDate() ?>.
    </p>
  </article>
<?php else : ?>
  <h1>400 - Bad request</h1>
  <h3>Désolé, je ne sais pas comment vous avez atterri ici 🤷‍♂️</h3>
  <a class="button button--secondary" href="/">Revenir à l'acceuil</a>
<?php endif; ?>