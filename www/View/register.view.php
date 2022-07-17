<h1>Register</h1>
<?php if(empty($user->getToken())) : ?>
  <?php $this->includePartial("form", $user->getRegisterForm()) ?>
<?php elseif($registerError) : ?>
  <div class="form">
    <div class="error">Email already used !</div>
  </div>
<?php elseif($user->getStatus() == 0) : ?>
  Register successfull
  <br>
    <?php if($isMailSent) : ?>
        Confirm your mail first please
    <?php else : ?>
        Serveur smtp down contact an admin bg
    <?php endif; ?>
<?php else : ?>
  Successfully connected to your account <?= $user->getUsername() ?>.
  <br>
  <a href="/logout">Log out</a> to create an account.
<?php endif; ?>
