<?php

require_once __DIR__ . '/../includes/auth_check.php';

$status = $_GET['status'] ?? 'active';
$query = trim((string) ($_GET['q'] ?? ''));
$where = match ($status) {
    'returned' => 'l.date_returned IS NOT NULL',
    'overdue' => 'l.date_returned IS NULL AND l.due_date < CURDATE()',
    default => 'l.date_returned IS NULL',
};
$statement = $pdo->prepare(
    "SELECT l.*, b.title, m.full_name
     FROM loans l
     JOIN books b ON b.book_id = l.book_id
     JOIN members m ON m.member_id = l.member_id
     WHERE {$where} AND (b.title LIKE ? OR m.full_name LIKE ? OR m.member_number LIKE ?)
     ORDER BY l.due_date"
);
$statement->execute(["%{$query}%", "%{$query}%", "%{$query}%"]);
$loans = $statement->fetchAll();
$page_title = 'Loans';
require __DIR__ . '/../includes/header.php';
?>
<div class="toolbar">
    <h1>Loans</h1>
    <a class="button" href="issue.php">Issue book</a>
</div>
<div class="card">
    <form method="get" class="form-grid">
        <div><label>Search book or member<input name="q" value="<?= e($query) ?>"></label></div>
        <div><label>Status
            <select name="status">
                <option value="active" <?= $status === 'active' ? 'selected' : '' ?>>Active</option>
                <option value="overdue" <?= $status === 'overdue' ? 'selected' : '' ?>>Overdue</option>
                <option value="returned" <?= $status === 'returned' ? 'selected' : '' ?>>Returned</option>
            </select>
        </label></div>
        <div class="full"><button class="button">Filter</button></div>
    </form>
</div>
<div class="card" style="margin-top: 20px">
    <div class="table-wrap">
        <table>
            <tr><th>Book</th><th>Member</th><th>Issued</th><th>Due</th><th>Returned</th><th>Action</th></tr>
            <?php foreach ($loans as $loan): ?>
                <tr>
                    <td><?= e($loan['title']) ?></td>
                    <td><?= e($loan['full_name']) ?></td>
                    <td><?= e($loan['date_issued']) ?></td>
                    <td><?= e($loan['due_date']) ?></td>
                    <td><?= e($loan['date_returned'] ?? '—') ?></td>
                    <td>
                        <?php if (!$loan['date_returned']): ?>
                            <form method="post" action="return.php" class="inline-form"><input type="hidden" name="id" value="<?= $loan['loan_id'] ?>"><button class="button small" data-confirm="Mark this book returned?">Return</button></form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>
<?php require __DIR__ . '/../includes/footer.php'; ?>
