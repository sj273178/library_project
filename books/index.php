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