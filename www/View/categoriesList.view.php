<div class="action-buttons">
  <a class="button button--primary button--big" href="/category-manager">New category</a>
</div>
<div class="category-list">
  <?php foreach ($categories as $category) : ?>
    <div class="category-list__item">
      <span class="category-list__item__name">
        <?= $category->name ?>
      </span>
      <a href="/category-manager?id=<?= $category->id ?>" class="button button--primary">Editer</a>
      <a href="/categories-list?deletedId=<?= $category->id ?>" class="button button--danger">Supprimer</a>
    </div>
  <?php endforeach; ?>
</div>