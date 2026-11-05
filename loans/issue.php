<?php

require_once __DIR__ . '/../includes/auth_check.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $memberId = (int) post('member_id');
    $bookId = (int) post('book_id');
    try {
        $pdo->beginTransaction();
        $memberStatement = $pdo->prepare('SELECT status FROM members WHERE member_id = ? FOR UPDATE');
        $memberStatement->execute([$memberId]);
        $member = $memberStatement->fetch();
        $bookStatement = $pdo->prepare('SELECT available_copies FROM books WHERE book_id = ? FOR UPDATE');
        $bookStatement->execute([$bookId]);
        $book = $bookStatement->fetch();
        $duplicate = $pdo->prepare('SELECT COUNT(*) FROM loans WHERE member_id = ? AND book_id = ? AND date_returned IS NULL');
        $duplicate->execute([$memberId, $bookId]);
        if (!$member || !$book) throw new RuntimeException('Choose a valid member and book.');
        if ($member['status'] !== 'active') throw new RuntimeException('Suspended members cannot borrow books.');
        if ($book['available_copies'] < 1) throw new RuntimeException('This book has no available copies.');
        if ((int) $duplicate->fetchColumn()) throw new RuntimeException('This member already has this book on loan.');
        $pdo->prepare('INSERT INTO loans (member_id, book_id, date_issued, due_date) VALUES (?, ?, CURDATE(), DATE_ADD(CURDATE(), INTERVAL 14 DAY))')->execute([$memberId, $bookId]);
        $pdo->prepare('UPDATE books SET available_copies = available_copies - 1 WHERE book_id = ?')->execute([$bookId]);
        $pdo->commit();
        flash('success', 'Book issued successfully. Due in 14 days.');
        redirect('/loans/index.php');
    } catch (Throwable $exception) {
        if ($pdo->inTransaction()) $pdo->rollBack();
        $error = $exception instanceof RuntimeException ? $exception->getMessage() : 'Unable to issue this book.';
    }
}
$members = $pdo->query("SELECT member_id, member_number, full_name FROM members WHERE status = 'active' ORDER BY full_name")->fetchAll();
$books = $pdo->query('SELECT book_id, title, available_copies FROM books WHERE available_copies > 0 ORDER BY title')->fetchAll();
$page_title = 'Issue book';
require __DIR__ . '/../includes/header.php';
?>
<h1>Issue book</h1>
<div class="card">
    <?php if ($error): ?><div class="alert alert-error"><?= e($error) ?></div><?php endif; ?>
    <form method="post" class="form-grid">
        <div><label>Member<select name="member_id" required><option value="">Select member</option><?php foreach ($members as $member): ?><option value="<?= $member['member_id'] ?>"><?= e($member['member_number'] . ' — ' . $member['full_name']) ?></option><?php endforeach; ?></select></label></div>
        <div><label>Book<select name="book_id" required><option value="">Select book</option><?php foreach ($books as $book): ?><option value="<?= $book['book_id'] ?>"><?= e($book['title'] . ' (' . $book['available_copies'] . ' available)') ?></option><?php endforeach; ?></select></label></div>
        <div class="full"><button class="button">Issue book</button></div>
    </form>
</div>
<?php require __DIR__ . '/../includes/footer.php'; ?>
