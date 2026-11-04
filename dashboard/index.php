<div class="toolbar">
    <div>
        <h1>Welcome, <?= e($_SESSION['full_name']) ?></h1>
        <p class="muted">A quick view of your library.</p>
    </div>
    <a class="button" href="<?= BASE_URL ?>/loans/issue.php">Issue a book</a>
</div>
<section class="stats">