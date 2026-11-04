<h1>Issue book</h1>
<div class="card">
    <?php if ($error): ?><div class="alert alert-error"><?= e($error) ?></div><?php endif; ?>
    <form method="post" class="form-grid">
        <div><label>Member<select name="member_id" required><option value="">Select member</option><?php foreach ($members as $member): ?><option value="<?= $member['member_id'] ?>"><?= e($member['member_number'] . ' — ' . $member['full_name']) ?></option><?php endforeach; ?></select></label></div>
        <div><label>Book<select name="book_id" required><option value="">Select book</option><?php foreach ($books as $book): ?><option value="<?= $book['book_id'] ?>"><?= e($book['title'] . ' (' . $book['available_copies'] . ' available)') ?></option><?php endforeach; ?></select></label></div>
        <div class="full"><button class="button">Issue book</button></div>
    </form>
</div>