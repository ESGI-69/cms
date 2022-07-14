<?php $data = [
  'config' => [
    'editButton' => false,
    'deleteButton' => false,
    'ignoredColumns' => [],
  ],
  'data' => $logs,
]; ?>

<?php $this->includePartial("table", $data);
