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
                    <td>sample</td>
                    <td>sample</td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>