<h1>Edit book</h1>
<div class="card">
    <?php if ($error): ?>
        <div class="alert alert-error"><?= e($error) ?></div>
    <?php endif; ?>
    <form method="post">
        <?php require 'form.php'; ?>
        <p><button class="button">Update book</button></p>
    </form>
</div>