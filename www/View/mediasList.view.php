<div class="action-buttons">
  <a class="button button--primary button--big" href="/article-manager">Ajouter un Média</a>
</div>
<div class="media-list">
  <?php foreach ($medias as $media) : ?>
    <div class="media-list__item">
      <img src="<?= $media["path"] ?>" alt="<?= $media["name"] ?>">
      <a href="/media-manager?id=<?= $media["id"] ?>" class="button">Editer</a>
      <a href="/medias-list?deletedId=<?= $media["id"] ?>" class="button">Supprimer</a>
    </div>
  <?php endforeach; ?>
</div>