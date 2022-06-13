<h1>Page d'accueil</h1>

<?php if ($isAuth) : ?>
  <p>Bienvenue <?= $userInfos["firstname"] ?></p>
  <a href="./logout">Se déconnecter</a>
<?php else : ?>
  <a href="./login">Se connecter</a>
  <a href="./register">S'inscrire</a>
<?php endif; ?>
<br>