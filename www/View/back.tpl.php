<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <title><?= $pageTitle ?></title>
  <?php if (isset($pageDescription)) : ?>
    <meta name="description" content="<?= $pageDescription ?>">
  <?php endif; ?>
  <link rel="stylesheet" href="/css/index.css">
</head>

<body class="<?= $this->template ?> <?= $this->view ?>">
  <script src="/js/chart.min.js"></script> <!-- Script de chart -->
  <script src="https://cdn.tiny.cloud/1/hwgre5j1e94ouquulufuygnjd0vqdzl0udis1n4fo7vjz7ia/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
  <script>
    tinymce.init({
      selector: 'textarea',
      plugins: 'a11ychecker advcode casechange export formatpainter image editimage linkchecker autolink lists checklist media mediaembed pageembed permanentpen powerpaste table advtable tableofcontents tinycomments tinymcespellchecker',
      toolbar: 'a11ycheck addcomment showcomments casechange checklist code export formatpainter image editimage pageembed permanentpen table tableofcontents',
      toolbar_mode: 'floating',
      tinycomments_mode: 'embedded',
      tinycomments_author: 'Author name',
    });
  </script>
  <?php include "Components/sidebar.component.php"; ?>
  <main class="view">
    <h1>
      <?= $this->shortedPageTitle ?>
    </h1>
    <?php include "View/" . $this->view . ".view.php"; ?>
  </main>
</body>

</html>