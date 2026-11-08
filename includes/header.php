<?php
if (!isset($page_title)) {
    $page_title = 'Library Management System';
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($page_title) ?></title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/styles.css">
</head>
<body>
    <?php require __DIR__ . '/navbar.php'; ?>
    <main class="page">
        <div class="container">
            <?php show_flash(); ?>
