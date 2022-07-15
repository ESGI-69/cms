<h1>Réinitialisation du mot de passe</h1>

<?php if (!$success) : ?>
  <p>
    Vous avez suivi le lien pour réinitialiser le mot de passe du compte <b><?= $user->getEmail() ?></b>.<br>
    Entrez votre nouveau mot de passe ce desssous.<br>
    Veuillez noter que votre mot de passe doit contenir au moins 8 caractères dont au minimim une majuscule, une minuscule, un chiffre et un caractère spécial.
  </p>
  <?php $this->includePartial("form", $user->getPasswordResetForm()) ?>
<?php else : ?>
  <p class="success">
    Votre mot de passe a été réinitialisé.
  </p>
  <a href="/login">Reconnectez vous !</a>
<?php endif; ?>