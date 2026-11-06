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