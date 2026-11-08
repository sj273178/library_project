<?php
require_once __DIR__ . '/../includes/auth_check.php';

$id = $_SERVER['REQUEST_METHOD'] === 'POST' ? valid_id(post('id')) : null;
if (!$id) { flash('error', 'Invalid member selected.'); redirect('/members/index.php'); }
$loanCount = $pdo->prepare('SELECT COUNT(*) FROM loans WHERE member_id = ? AND date_returned IS NULL');
$loanCount->execute([$id]);

if ((int) $loanCount->fetchColumn() > 0) {
    flash('error', 'This member cannot be deleted because they have unreturned books.');
} else {
    try {
        $pdo->prepare('DELETE FROM members WHERE member_id = ?')->execute([$id]);
        flash('success', 'Member deleted successfully.');
    } catch (PDOException $exception) {
        flash('error', 'This member cannot be deleted because loan history depends on it.');
    }
}

redirect('/members/index.php');
