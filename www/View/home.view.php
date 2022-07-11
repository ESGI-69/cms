<span class="username">Bonjour <?= $userInfos["firstname"] ?? 'étranger' ?> 👋 </span>
<span class="question">Que veux tu apprendre aujourd'hui ?</span>
<form class="search" action="search.php" method="get">
  <input class="input" type="text" name="search" placeholder="Rechercher un article" />
  <button class="button button--primary button--big" type="submit">Search</button>
</form>
<span class="last-article">
  <h2 class="last-article__title">Recent posts</h2>
  <div class="last-article__list">
    <?php foreach ($articles as $article) : ?>
      <div class="last-article__list__item">
        <img class="last-article__list__item__img" src="<?= $article->media_id ?>" alt="<?= $article->title ?>" />
        <a href="/article?id=<?= $article->id ?>" class="last-article__list__item__link">
          <h3><?= $article->title ?></h3>
        </a>
        <span class="last-article__list__item__date"><?= $article->createdAt ?></span>
        <!-- Author -->
        <span class="last-article__list__item__author"><?= $article->user_id ?></span>
        <p class="last-article__list__item__content"><?= $article->content ?></p>
      </div>
    <?php endforeach; ?>
  </div>
</span>