<?php if (!$success) : ?>
  <?php $this->includePartial("form", $article->getFrom()) ?>
<?php else : ?>
  <?php header("Location: /articles-list"); ?>
<?php endif; ?>