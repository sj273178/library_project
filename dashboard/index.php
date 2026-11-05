<?php
require_once __DIR__ . '/../includes/auth_check.php';

$counts = [];
foreach (['books' => 'Books', 'members' => 'Members', 'loans' => 'Active loans'] as $table => $label) {
    $sql = $table === 'loans'
        ? 'SELECT COUNT(*) FROM loans WHERE date_returned IS NULL'
        : "SELECT COUNT(*) FROM {$table}";
    $counts[$label] = (int) $pdo->query($sql)->fetchColumn();
}
$counts['Overdue loans'] = (int) $pdo->query(
    'SELECT COUNT(*) FROM loans WHERE date_returned IS NULL AND due_date < CURDATE()'
)->fetchColumn();

$page_title = 'Dashboard';
require __DIR__ . '/../includes/header.php';
?>
<div class="toolbar">
    <div>
        <h1>Welcome, <?= e($_SESSION['full_name']) ?></h1>
        <p class="muted">A quick view of your library.</p>
    </div>
    <a class="button" href="<?= BASE_URL ?>/loans/issue.php">Issue a book</a>
</div>
<section class="stats">
    <?php foreach ($counts as $label => $count): ?>
        <div class="stat"><span><?= e($label) ?></span><strong><?= $count ?></strong></div>
    <?php endforeach; ?>
</section>
<?php require __DIR__ . '/../includes/footer.php'; ?>