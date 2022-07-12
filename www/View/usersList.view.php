<div class="action-buttons">
  <a class="button button--primary button--big" href="/user-manager">New user</a>
</div>

<?php foreach ($users as $user) : ?>
  <div>
    <span><?= $user->firstname ?> | </span>
    <span><?= $user->email ?> | </span>
    <span><?= $user->role ?> | </span>
    <a href="/user-manager?id=<?= $user->id ?>" class="button button--primary">Editer</a>
    <a href="/users-list?deletedId=<?= $user->id ?>" class="button button--danger">Supprimer</a>
  </div>
<?php endforeach; ?>
