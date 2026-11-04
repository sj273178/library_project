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