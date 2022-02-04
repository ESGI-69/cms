<h1>Page de login</h1>

<?php if(empty($user->getToken())) : ?>
  <?php $this->includePartial("form", $user->getLoginForm())
    //TODO messages d'erreurs et de success
  ?>
<?php endif; ?>
