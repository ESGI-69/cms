<div class="action-buttons">
  <a class="button button--primary button--big" href="/user-manager">New user</a>
</div>

<?php $data = [
  'config' => [
    'editButton' => true,
    'deleteButton' => true,
    'editUrl' => '/user-manager',
    'deleteUrl' => '/users-list',
    'ignoredColumns' => ['password', 'token', 'emailVerifyToken'],
  ],
  'data' => $users,
]; ?>

<?php $this->includePartial("table", $data); ?>
