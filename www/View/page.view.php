<?php if (isset($_GET['id'])) : ?>
<h1>Page</h1>
<?php else : ?>
  <h1>400 - Bad request</h1>
  <h3>Désolé, je ne sais pas comment vous avez atterri ici 🤷‍♂️</h3>
  <a class="button button--secondary" href="/">Revenir à l'acceuil</a>
<?php endif; ?>