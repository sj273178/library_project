<?php
require_once __DIR__ . '/../includes/auth_check.php';

$id = valid_id((string) ($_GET['id'] ?? ''));
if (!$id) { flash('error', 'Member not found.'); redirect('/members/index.php'); }
$statement = $pdo->prepare('SELECT * FROM members WHERE member_id = ?');
$statement->execute([$id]);
$member = $statement->fetch();
if (!$member) { flash('error', 'Member not found.'); redirect('/members/index.php'); }
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST;
    if (post('member_number') === '' || post('full_name') === '' || !filter_var(post('email'), FILTER_VALIDATE_EMAIL) || post('phone') === '') {
        $error = 'Complete all fields and use a valid email address.';
    } else {
        try {
            $status = post('status') === 'suspended' ? 'suspended' : 'active';
            $pdo->prepare('UPDATE members SET member_number = ?, full_name = ?, email = ?, phone = ?, status = ? WHERE member_id = ?')->execute([post('member_number'), post('full_name'), post('email'), post('phone'), $status, $id]);
            flash('success', 'Member updated successfully.');
            redirect('/members/index.php');
        } catch (PDOException $exception) { $error = 'Member number and email address must each be unique.'; }
    }
    $member = array_merge($member, $data);
}
$page_title = 'Edit member'; require __DIR__ . '/../includes/header.php';
?>
<h1>Edit member</h1>
<div class="card">
    <?php if ($error): ?><div class="alert alert-error"><?= e($error) ?></div><?php endif; ?>
    <form method="post" class="form-grid">
        <?php require __DIR__ . '/form.php'; ?>
        <div class="full"><button class="button">Update member</button></div>
    </form>
</div>
<?php require __DIR__ . '/../includes/footer.php'; ?>
