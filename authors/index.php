<?php
// Owner: Farid Musa | Commit stage: 1 of 1 (authors management)
require_once __DIR__ . '/../includes/auth_check.php';

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = post('name');
    $country = post('country');
    if ($name === '' || $country === '') {
        $errors[] = 'Name and country are required.';
    } else {
        try {
            $pdo->prepare('INSERT INTO authors (name, country) VALUES (?, ?)')->execute([$name, $country]);
            flash('success', 'Author added successfully.');
            redirect('/authors/index.php');
        } catch (PDOException $exception) {
            $errors[] = 'That author already exists.';
        }
    }
}
$authors = $pdo->query('SELECT * FROM authors ORDER BY name')->fetchAll();
$page_title = 'Authors';
require __DIR__ . '/../includes/header.php';
?>


<div class="toolbar"><h1>Authors</h1></div>
<div class="card">
    <form method="post" class="form-grid">
        <div><label>Name<input name="name" required></label></div>
        <div><label>Country<input name="country" required></label></div>
        <div class="full"><button class="button">Add author</button></div>
    </form>

    <?php foreach ($errors as $error): ?>
        <div class="alert alert-error"><?= e($error) ?></div>
    <?php endforeach; ?>
    </div>

    <div class="card" style="margin-top: 20px">
    <div class="table-wrap"><table><tr><th>Name</th><th>Country</th></tr>
        <?php foreach ($authors as $author): ?>
            <tr><td><?= e($author['name']) ?></td><td><?= e($author['country']) ?></td></tr>
        <?php endforeach; ?>
    </table></div>
</div>
<?php require __DIR__ . '/../includes/footer.php'; ?>
   

