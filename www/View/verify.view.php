<h1>Verify</h1>

<?php if($isEmailVerified) : ?>
  Votre email a été vérifié !
  <br>
    <a href="/login">Connectez vous</a> pour commencer a explorer ce wiki :)
<?php else : ?>
  Oops, ce lien n'est plus valide :(
  <br>
  <br>
  Cet email a peut etre été déjà verifié.
<?php endif; ?>
