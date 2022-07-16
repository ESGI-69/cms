<?php if (isset($category)) : ?>
  <h1><?= $category->getName() ?></h1>
  <?php if (!empty($articles)) : ?>
    <p>Voici une list des articles dans cette categorie. Les articles sont triée par odre alphabetique.</p>
    <div class="articles">
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
  <?php else : ?>
    <p>Aucun article n'a été créé dans cette catégorie.</p>
  <?php endif; ?>
<?php else : ?>
  <h1>400 - Bad request</h1>
  <h3>Désolé, je ne sais pas comment vous avez atterri ici 🤷‍♂️</h3>
  <a class="button button--secondary" href="/">Revenir à l'acceuil</a>
<?php endif; ?>