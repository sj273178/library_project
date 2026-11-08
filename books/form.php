<?php
$authors = $pdo->query('SELECT * FROM authors ORDER BY name')->fetchAll();
$categories = $pdo->query('SELECT * FROM categories ORDER BY name')->fetchAll();
?>
<div class="form-grid">
    <div><label>ISBN
        <input name="isbn" required value="<?= e($book['isbn'] ?? '') ?>">
    </label></div>
    <div><label>Title
        <input name="title" required value="<?= e($book['title'] ?? '') ?>">
    </label></div>
    <div><label>Author
        <select name="author_id" required>
            <?php foreach ($authors as $author): ?>
                <option value="<?= $author['author_id'] ?>" <?= ($book['author_id'] ?? 0) == $author['author_id'] ? 'selected' : '' ?>><?= e($author['name']) ?></option>
            <?php endforeach; ?>
        </select>
    </label></div>
    <div><label>Category
        <select name="category_id" required>
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category['category_id'] ?>" <?= ($book['category_id'] ?? 0) == $category['category_id'] ? 'selected' : '' ?>><?= e($category['name']) ?></option>
            <?php endforeach; ?>
              </select>
    </label></div>
    <div><label>Publisher
        <input name="publisher" required value="<?= e($book['publisher'] ?? '') ?>">
    </label></div>
    <div><label>Year published
        <input type="number" name="year_published" min="1000" max="<?= date('Y') ?>" required value="<?= e((string) ($book['year_published'] ?? date('Y'))) ?>">
    </label></div>
    <div><label>Total copies
        <input type="number" name="total_copies" min="1" required value="<?= e((string) ($book['total_copies'] ?? 1)) ?>">
    </label></div>
</div>
