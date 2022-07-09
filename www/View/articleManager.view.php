<?php if (!$success) : ?>
  <?php $this->includePartial("form", $article->getForm()) ?>
<?php else : ?>
  <?php header("Location: /articles-list"); ?>
<?php endif; ?>