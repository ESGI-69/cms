<a href="/media-manager">Ajouter</a>

<?php foreach ($medias as $media) : ?>
  <img src="<?= $media["path"] ?>" alt="<?= $media["name"] ?>">
  <a href="/media-manager?id=<?= $media["id"]?>" class="button">Editer</a>
  <a href="/medias-list?deletedId=<?= $media["id"]?>" class="button">Supprimer</a>
<?php endforeach; ?>