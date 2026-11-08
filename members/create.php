<?php
require_once __DIR__ . '/../includes/auth_check.php'; $member = []; $error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $member = $_POST;
    if (post('member_number') === '' || post('full_name') === '' || !filter_var(post('email'), FILTER_VALIDATE_EMAIL) || post('phone') === '') { $error = 'Complete all fields and use a valid email address.'; }
    else { try { $status = post('status') === 'suspended' ? 'suspended' : 'active'; $pdo->prepare('INSERT INTO members (member_number, full_name, email, phone, status, date_joined) VALUES (?, ?, ?, ?, ?, CURDATE())')->execute([post('member_number'), post('full_name'), post('email'), post('phone'), $status]); flash('success', 'Member added successfully.'); redirect('/members/index.php'); } catch (PDOException $exception) { $error = 'Member number and email address must each be unique.'; } }
}
$page_title = 'Add member'; require __DIR__ . '/../includes/header.php';
?>
<h1>Add member</h1><div class="card"><?php if ($error): ?><div class="alert alert-error"><?= e($error) ?></div><?php endif; ?><form method="post" class="form-grid"><?php require __DIR__ . '/form.php'; ?><div class="full"><button class="button">Save member</button></div></form></div><?php require __DIR__ . '/../includes/footer.php'; ?>
