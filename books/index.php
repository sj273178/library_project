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
//space for php code.

        </select></label></div>
        <div class="full"><button class="button">Search</button></div>
    </form>
</div>
<div class="card" style="margin-top: 20px"><div class="table-wrap"><table>
    <tr><th>ISBN</th><th>Title</th><th>Author</th><th>Category</th><th>Available</th><th>Actions</th></tr>

    