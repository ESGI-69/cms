<?php if (isset($page) && $page !== false) : ?>
  <div class="page">
    <h1><?= $page->getTitle() ?></h1>
    <?php if ($page->getSubtitle() && $page->getSubtitle() !== 'NULL') : ?>
      <h4><?= $page->getSubtitle() ?></h4>
    <?php endif; ?>
    <div id="content"><?= $page->getContent() ?></div>      
  </div>
<?php else : ?>
  <h1>400 - Bad request</h1>
  <h3>Désolé, je ne sais pas comment vous avez atterri ici 🤷‍♂️</h3>
  <a class="button button--secondary" href="/">Revenir à l'acceuil</a>
<?php endif; ?>