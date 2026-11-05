<?php

require_once __DIR__ . '/../includes/auth_check.php';

$book = [];
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $book = $_POST;
    $total = integer(post('total_copies'), 1);
    $year = integer(post('year_published'), 1000);
    if (post('isbn') === '' || post('title') === '' || post('publisher') === '' || !$total || !$year || $year > (int) date('Y')) {
        $error = 'Complete all fields with valid values.';
    } else {
        try {
            $pdo->prepare('INSERT INTO books (isbn, title, author_id, category_id, publisher, year_published, total_copies, available_copies) VALUES (?, ?, ?, ?, ?, ?, ?, ?)')->execute([post('isbn'), post('title'), (int) post('author_id'), (int) post('category_id'), post('publisher'), $year, $total, $total]);
            flash('success', 'Book added successfully.');
            redirect('/books/index.php');
        } catch (PDOException $exception) {
            $error = 'ISBN must be unique.';
        }
    }
}
$page_title = 'Add book';
require __DIR__ . '/../includes/header.php';
?>

<h1>Add book</h1>
<div class="card">
    <?php if ($error): ?>
        <div class="alert alert-error"><?= e($error) ?></div>
    <?php endif; ?>
    <form method="post">
        <?php require 'form.php'; ?>
        <p><button class="button">Save book</button></p>
    </form>
</div>
<?php require __DIR__ . '/../includes/footer.php'; ?>