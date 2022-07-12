<?php if (isset($article) && $article !== false) : ?>
  <article>
    <h1><?= $article->getTitle() ?></h1>
    <img src="<?= $article->getMediaPath() ?>" alt="<?= $article->getTitle() ?>">
    <div id="content"></div>
    <script>
      const articleContent = `<?= html_entity_decode(html_entity_decode($article->getContent())) ?>`;
      console.log(articleContent);
      const content = document.getElementById('content');
      content.innerHTML = articleContent;
    </script>
    <p class="end">
      Publié par <b><?= $article->getAuthorFirstname() ?> <?= $article->getAuthorLastname() ?></b> dans <?= $article->getCategoryName() ?> le <?= $article->getArticleCreationDate() ?>.
    </p>
  </article>
<?php else : ?>
  <h1>400 - Bad request</h1>
  <h3>Désolé, je ne sais pas comment vous avez atterri ici 🤷‍♂️</h3>
  <a class="button button--secondary" href="/">Revenir à l'acceuil</a>
<?php endif; ?>