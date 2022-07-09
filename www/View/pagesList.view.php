<div class="action-buttons">
  <a class="button button--primary button--big" href="/page-manager">New page</a>
</div>

<?php foreach ($pages as $page) : ?>
  <div>
    <p><?= $page->title ?></p>
    <a href="/page-manager?id=<?= $page->id ?>" class="button button--primary">Editer</a>
    <a href="/pages-list?deletedId=<?= $page->id ?>" class="button button--danger">Supprimer</a>
  </div>
<?php endforeach; ?>
