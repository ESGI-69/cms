<?php if (!$success) : ?>
  <?php $this->includePartial("form", $article->getFrom($_GET['sectionsQuantity'] ?? 0, $_GET['additionalSectionsQuantity'] ?? 0)) ?>
<?php else : ?>
  <p>
    Bravo <?= $userInfos["firstname"] ?>, vous êtes connecté ! 👏
  </p>
  <a href="/">Retour à l'accueil</a>
<?php endif; ?>