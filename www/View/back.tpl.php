<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title><?= $pageTitle ?></title>
    <?php if (isset($pageDescription)) : ?>
        <meta name="description" content="<?= $pageDescription ?>">
    <?php endif; ?>
    <link rel="stylesheet" href="css/index.css">
</head>

<body>
    <script src="/js/chart.min.js"></script>
    <?php include "Components/sidebar.component.php"; ?>
    <main class="view">
        <?php include "View/" . $this->view . ".view.php"; ?>
    </main>
</body>

</html>