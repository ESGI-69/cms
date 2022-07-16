<span class="username">Bonjour <?= $userInfos["firstname"] ?? 'étranger' ?> 👋 </span>
<span class="question">Que veux tu apprendre aujourd'hui ?</span>
<form class="search" action="search.php" method="get">
  <input class="input" type="text" name="search" placeholder="Rechercher un article" />
  <button class="button button--primary button--big" type="submit">Search</button>
</form>
<div class="articles">
  <h2 class="articles__title">Les articles les plus récents</h2>
  <div class="articles__list">
    <?php foreach ($articles as $article) : ?>
      <a href="/article?id=<?= $article->getId() ?>" class="articles__list__item">
        <h3 class="articles__list__item__title"><?= $article->getTitle() ?></h3>
        <img class="articles__list__item__image" src="<?= $article->getMediaPath() ?>" alt="<?= $article->getTitle() ?>" />
        <span class="articles__list__item__creation-infos">Le <?= $article->getArticleCreationDate() ?> par <?= $article->getAuthorFirstname() ?> <?= $article->getAuthorLastname() ?></span>
        <p class="articles__list__item__content"><?= $article->getShortedContent() ?>...</p>
      </a>
    <?php endforeach; ?>
  </div>
</div>