<h1>Mot de passe oublié</h1>

<?php if (!$success) : ?>
  <p>
    Entrez ci dessous l'email associée à votre compte.<br>
    Nous vous enverrons un lien pour réinitialiser votre mot de passe.
  </p>
  <?php $this->includePartial("form", $user->getPasswordForgetForm()) ?>
<?php else : ?>
  <p class="success">
    Le mail de réinitialisation du mot de passe à été envoyé à <?= $email ?>.
  </p>
  <a href="/">Retour à l'accueil</a>
<?php endif; ?>