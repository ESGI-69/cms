<h1>Catégories</h1>
<p>Sur cette page vous pouvez voir les différentes catégories disponible sur le site. Elle sont triées par ordre alphabétique.</p>

<?php if (empty($categories)) : ?>
  <p>Aucune catégorie n'a été créée pour le moment.</p>
<?php else : ?>
  <ul>
    <?php foreach ($categories as $category) : ?>
      <li>
        <a href="/category?id=<?= $category->id ?>"><?= $category->name ?></a>
      </li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>