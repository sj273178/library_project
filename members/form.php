<div><label>Member number<input name="member_number" required value="<?= e($member['member_number'] ?? '') ?>"></label></div>
<div><label>Full name<input name="full_name" required value="<?= e($member['full_name'] ?? '') ?>"></label></div>
<div><label>Email address<input type="email" name="email" required value="<?= e($member['email'] ?? '') ?>"></label></div>
<div><label>Phone number<input name="phone" required value="<?= e($member['phone'] ?? '') ?>"></label></div>
<div><label>Status<select name="status"><option value="active" <?= ($member['status'] ?? 'active') === 'active' ? 'selected' : '' ?>>Active</option><option value="suspended" <?= ($member['status'] ?? '') === 'suspended' ? 'selected' : '' ?>>Suspended</option></select></label></div>
