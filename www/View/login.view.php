<h1>Page de login</h1>

<?php if($login === false ) : ?>
  <?php $this->includePartial("form", $user->getLoginForm()) ?>
  <?=$loginError ?>
<?php else : ?>
  BIENVENUE <?= $userInfos["firstname"] ?>
<?php endif; ?>
