<?php

require_once __DIR__ . '/../includes/auth_check.php';

$id = (int) ($_GET['id'] ?? 0);
$loanCount = $pdo->prepare('SELECT COUNT(*) FROM loans WHERE book_id = ? AND date_returned IS NULL');
$loanCount->execute([$id]);

if ((int) $loanCount->fetchColumn() > 0) {
    flash('error', 'This book cannot be deleted because it has unreturned loans.');
} else {
    try {
        $pdo->prepare('DELETE FROM books WHERE book_id = ?')->execute([$id]);
        flash('success', 'Book deleted successfully.');
    } catch (PDOException $exception) {
        flash('error', 'This book cannot be deleted because loan history depends on it.');
    }
}

redirect('/books/index.php');