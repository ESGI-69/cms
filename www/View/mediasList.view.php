<?php
echo mb_strimwidth(
  trim(
    preg_replace(
      '/-+/',
      '-',
      preg_replace(
        '/[^A-Za-z0-9\-]/',
        '',
        str_replace(
          ' ',
          '-',
          strtolower("k da dza §è§(' uàj zf")
        )
      )
    ),
    '-'
  ),
  0,
  92
) . "-" . date('y-m-d');

?>

<!-- <img src="/user-media/synthwave.webp" alt=""> -->

<pre>
  <?php # print_r($medias) ?>
</pre>

<?php foreach ($medias as $media) : ?>
  <img src="<?= $media["path"] ?>" alt="<?= $media["name"] ?>">
  <a href="/media-manager?editId=<?= $media["id"]?>" class="button">Editer</a>
  <a href="/medias-list?deletedId=<?= $media["id"]?>" class="button">Supprimer</a>
<?php endforeach; ?>