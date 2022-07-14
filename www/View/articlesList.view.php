<div class="action-buttons">
  <a class="button button--primary button--big" href="/article-manager">New article</a>
</div>

<?php $data = [
  'config' => [
    'editButton' => true,
    'deleteButton' => true,
    'editUrl' => '/article-manager',
    'deleteUrl' => '/articles-list',
    'ignoredColumns' => [],
  ],
  'data' => $articles,
]; ?>

<?php $this->includePartial("table", $data); ?>