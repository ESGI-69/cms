<div class="action-buttons">
  <a class="button button--primary button--big" href="/article-manager">New article</a>
</div>

<?php foreach ($articles as $article) : ?>
  <div>
    <p><?= $article->title ?></p>
    <a href="/article-manager?id=<?= $article->id ?>" class="button button--primary">Editer</a>
    <a href="/articles-list?deletedId=<?= $article->id ?>" class="button button--danger">Supprimer</a>
  </div>
<?php endforeach; ?>