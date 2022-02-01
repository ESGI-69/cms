<h1>S'inscrire</h1>

<?php if(empty($user->getToken())) : ?>
  <?php $this->includePartial("form", $user->getRegisterForm()) ?>
<?php elseif($user->getStatus() == 0) : ?>
  Vous etes bien inscrit.
  <br>
  Veuillez vérifier votre email pour pouvoir utiliser votre compte.
<?php else : ?>
  Vous etes actuellement connecté au compte <?= $user->getUsername() ?>.
  <br>
  <a href="/logout">Deconnectez vous</a> pour créer un compte.
<?php endif; ?>
