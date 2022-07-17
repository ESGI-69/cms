<h1>Login</h1>

<?php if (!$success) : ?>
  <?php $this->includePartial("form", $user->getLoginForm()) ?>
  <a href="/forget">
    Mot de passe oublié ?
  </a>
<?php else : ?>
  <p>
    Bravo <?= $userInfos["firstname"] ?>, vous êtes connecté ! 👏
  </p>
  <a href="/">Retour à l'accueil</a>
<?php endif; ?>