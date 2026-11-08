<?php

require_once __DIR__ . '/../includes/auth_check.php';

$id = $_SERVER['REQUEST_METHOD'] === 'POST' ? valid_id(post('id')) : null;
if (!$id) { flash('error', 'Invalid loan selected.'); redirect('/loans/index.php'); }

try {
    $pdo->beginTransaction();

    $loanStatement = $pdo->prepare(
        'SELECT book_id FROM loans WHERE loan_id = ? AND date_returned IS NULL FOR UPDATE'
    );
    $loanStatement->execute([$id]);
    $loan = $loanStatement->fetch();

    if (!$loan) {
        throw new RuntimeException('Active loan not found.');
    }

    $pdo->prepare('UPDATE loans SET date_returned = CURDATE() WHERE loan_id = ?')->execute([$id]);
    $pdo->prepare('UPDATE books SET available_copies = available_copies + 1 WHERE book_id = ?')
        ->execute([$loan['book_id']]);

    $pdo->commit();
    flash('success', 'Book marked as returned.');
} catch (Throwable $exception) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    flash('error', 'Unable to return this book.'); 
    
}

redirect('/loans/index.php');
