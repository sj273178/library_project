<?php
require_once __DIR__ . '/../includes/auth_check.php';

$query = trim($_GET['q'] ?? '');
$statement = $pdo->prepare('SELECT * FROM members WHERE full_name LIKE ? OR member_number LIKE ? ORDER BY full_name');
$statement->execute(["%{$query}%", "%{$query}%"]);
$members = $statement->fetchAll();
$page_title = 'Members'; require __DIR__ . '/../includes/header.php';
?>
<div class="toolbar"><h1>Members</h1><a class="button" href="create.php">Add member</a></div>
<div class="card"><form method="get"><label>Search name or member number<input name="q" value="<?= e($query) ?>"></label><p><button class="button">Search</button></p></form></div>
<div class="card" style="margin-top: 20px"><div class="table-wrap"><table>
    <tr><th>Number</th><th>Name</th><th>Email</th><th>Phone</th><th>Status</th><th>Actions</th></tr>
    <?php foreach ($members as $member): ?>
        <tr><td><?= e($member['member_number']) ?></td><td><?= e($member['full_name']) ?></td><td><?= e($member['email']) ?></td><td><?= e($member['phone']) ?></td><td><?= e($member['status']) ?></td><td class="actions"><a class="button small secondary" href="edit.php?id=<?= $member['member_id'] ?>">Edit</a><form method="post" action="delete.php" class="inline-form"><input type="hidden" name="id" value="<?= $member['member_id'] ?>"><button class="button small danger" data-confirm="Delete this member?">Delete</button></form></td></tr>
    <?php endforeach; ?>
</table></div></div>
<?php require __DIR__ . '/../includes/footer.php'; ?>
