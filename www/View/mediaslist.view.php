<div class="action-buttons">
  <a class="button button--primary button--big" href="/media-manager">New media</a>
</div>
<div class="media-list">
  <?php foreach ($medias as $media) : ?>
    <div class="media-list__item">
      <img src="<?= $media->path ?>" alt="<?= $media->name ?>">
      <div class="media-list__item__info">
        <span class="media-list__item__info__name">
          <?= $media->name ?>
        </span>
        <a href="/medias-list?deletedId=<?= $media->id ?>" class="button button--danger">Supprimer</a>
      </div>
    </div>
  <?php endforeach; ?>
</div>