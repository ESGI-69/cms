<h1>Connexion</h1>

<?php if (!$success) : ?>
  <?php $this->includePartial("form", $user->getLoginForm()) ?>
<?php else : ?>
  <p>
    Bravo <?= $userInfos["firstname"] ?>, vous êtes connecté ! 👏
  </p>
  <a href="/">Retour à l'accueil</a>
<?php endif; ?>