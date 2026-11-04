<?php

require_once __DIR__ . '/../includes/auth_check.php';

$id = (int) ($_GET['id'] ?? 0);
$statement = $pdo->prepare('SELECT * FROM books WHERE book_id = ?');
$statement->execute([$id]);
$book = $statement->fetch();
if (!$book) {
    flash('error', 'Book not found.');
    redirect('/books/index.php');
}
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST;
    $total = integer(post('total_copies'), 1);
    $year = integer(post('year_published'), 1000);
    $onLoan = $book['total_copies'] - $book['available_copies'];
    if (!$total || $total < $onLoan || !$year || $year > (int) date('Y')) {
        $error = 'Use valid values; total copies cannot be below copies on loan.';
    } else {
        try {
            $available = $total - $onLoan;
            $pdo->prepare('UPDATE books SET isbn = ?, title = ?, author_id = ?, category_id = ?, publisher = ?, year_published = ?, total_copies = ?, available_copies = ? WHERE book_id = ?')->execute([post('isbn'), post('title'), (int) post('author_id'), (int) post('category_id'), post('publisher'), $year, $total, $available, $id]);
            flash('success', 'Book updated successfully.');
            redirect('/books/index.php');
        } catch (PDOException $exception) {
            $error = 'ISBN must be unique.';
        }
    }
    $book = array_merge($book, $data);
}
$page_title = 'Edit book';
require __DIR__ . '/../includes/header.php';
?>
<h1>Edit book</h1>
<div class="card">
    <?php if ($error): ?>
        <div class="alert alert-error"><?= e($error) ?></div>
    <?php endif; ?>
    <form method="post">
        <?php require 'form.php'; ?>
        <p><button class="button">Update book</button></p>
    </form>
</div>
<?php require __DIR__ . '/../includes/footer.php'; ?>