<div class="action-buttons">
  <a class="button button--primary button--big" href="/page-manager">New page</a>
</div>

<?php $data = [
  'config' => [
    'editButton' => true,
    'deleteButton' => true,
    'editUrl' => '/page-manager',
    'deleteUrl' => '/pages-list',
    'ignoredColumns' => [],
  ],
  'data' => $pages,
]; ?>

<?php $this->includePartial("table", $data); ?>