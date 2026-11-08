<?php

require_once __DIR__ . '/../includes/auth_check.php';

$query = trim($_GET['q'] ?? '');
$category = (int) ($_GET['category'] ?? 0);
$sql = 'SELECT b.*, a.name AS author, c.name AS category FROM books b JOIN authors a ON a.author_id = b.author_id JOIN categories c ON c.category_id = b.category_id WHERE (b.title LIKE ? OR a.name LIKE ? OR c.name LIKE ?)';
$parameters = ["%{$query}%", "%{$query}%", "%{$query}%"];
if ($category) {
    $sql .= ' AND b.category_id = ?';
    $parameters[] = $category;
}
$sql .= ' ORDER BY b.title';
$statement = $pdo->prepare($sql);
$statement->execute($parameters);
$books = $statement->fetchAll();
$categories = $pdo->query('SELECT * FROM categories ORDER BY name')->fetchAll();
$page_title = 'Books';
require __DIR__ . '/../includes/header.php';
?>

<div class="toolbar">
    <h1>Books</h1>
    <a class="button" href="create.php">Add book</a>
</div>
<div class="card">
    <form method="get" class="form-grid">
        <div><label>Search<input name="q" value="<?= e($query) ?>" placeholder="Title, author or category"></label></div>
        <div><label>Category<select name="category"><option value="">All categories</option>
            <?php foreach ($categories as $item): ?>
                <option value="<?= $item['category_id'] ?>" <?= $category === (int) $item['category_id'] ? 'selected' : '' ?>><?= e($item['name']) ?></option>
            <?php endforeach; ?>
        </select></label></div>
        <div class="full"><button class="button">Search</button></div>
    </form>
</div>
<div class="card" style="margin-top: 20px"><div class="table-wrap"><table>
    <tr><th>ISBN</th><th>Title</th><th>Author</th><th>Category</th><th>Available</th><th>Actions</th></tr>
 <?php foreach ($books as $book): ?>
        <tr><td><?= e($book['isbn']) ?></td><td><?= e($book['title']) ?></td><td><?= e($book['author']) ?></td><td><?= e($book['category']) ?></td><td><?= $book['available_copies'] ?> / <?= $book['total_copies'] ?></td><td class="actions"><a class="button small secondary" href="edit.php?id=<?= $book['book_id'] ?>">Edit</a><form method="post" action="delete.php" class="inline-form"><input type="hidden" name="id" value="<?= $book['book_id'] ?>"><button class="button small danger" data-confirm="Delete this book?">Delete</button></form></td></tr>
    <?php endforeach; ?>
</table></div></div>
<?php require __DIR__ . '/../includes/footer.php'; ?>
