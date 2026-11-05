<?php
require_once __DIR__ . '/../includes/auth_check.php';

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = post('name');
    $description = post('description');
    if ($name === '' || $description === '') {
        $errors[] = 'Name and description are required.';
    } else {
        try {
            $pdo->prepare('INSERT INTO categories (name, description) VALUES (?, ?)')->execute([$name, $description]);
            flash('success', 'Category added successfully.');
            redirect('/categories/index.php');
        } catch (PDOException $exception) {
            $errors[] = 'That category already exists.';
        }
    }
}
$categories = $pdo->query('SELECT * FROM categories ORDER BY name')->fetchAll();
$page_title = 'Categories';
require __DIR__ . '/../includes/header.php';
?>
<div class="toolbar">
    <h1>Categories</h1>
</div>

<div class="card">
    <form method="post" class="form-grid">
        <div>
            <label>Name <input name="name" required></label>
        </div>
        <div>
            <label>Description <input name="description" required></label>
        </div>
        <div class="full">
            <button class="button">Add category</button>
        </div>
    </form>

    <?php foreach ($errors as $error): ?>
        <div class="alert alert-error"><?= e($error) ?></div>
    <?php endforeach; ?>
</div>

<div class="card" style="margin-top: 20px;">
    <div class="table-wrap">
        <table>
            <tr>
                <th>Name</th>
                <th>Description</th>
            </tr>
            <?php foreach ($categories as $category): ?>
                <tr>
                    <td><?= e($category['name']) ?></td>
                    <td><?= e($category['description']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>