<div class="action-buttons">
  <a class="button button--primary button--big" href="/category-manager">New category</a>
</div>

<?php $data = [
  'config' => [
    'editButton' => true,
    'deleteButton' => true,
    'editUrl' => '/category-manager',
    'deleteUrl' => '/categories-list',
    'ignoredColumns' => [],
  ],
  'data' => $categories,
]; ?>

<?php $this->includePartial("table", $data); ?>