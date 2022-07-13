<?php $data = [
  'config' => [
    'editButton' => false,
    'deleteButton' => false,
  ],
  'data' => $logs,
]; ?>

<?php $this->includePartial("table", $data);
