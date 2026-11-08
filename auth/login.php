<?php
declare(strict_types=1);

session_start();

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';

if (!empty($_SESSION['user_id'])) {
    redirect('/dashboard/index.php');
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = post('username');
    $password = (string) ($_POST['password'] ?? '');

    if ($username === '' || $password === '') {
        $error = 'Enter your username and password.';
    } else {
        $statement = $pdo->prepare('SELECT user_id, username, password_hash, full_name, user_role FROM users WHERE username = ?');
        $statement->execute([$username]);
        $user = $statement->fetch();

        if (!$user || !password_verify($password, $user['password_hash'])) {
            $error = 'The username or password is incorrect.';
        } else {
            session_regenerate_id(true);
            $_SESSION['user_id'] = (int) $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['user_role'] = $user['user_role'];

            flash('success', 'Welcome back, ' . $user['full_name'] . '.');
            redirect('/dashboard/index.php');
        }
    }
}

$page_title = 'Sign in';
require __DIR__ . '/../includes/header.php';
?>
<section class="auth-card card">
    <h1>Library Management System</h1>
    <p class="muted">Sign in to manage the library.</p>

    <?php if ($error): ?>
        <div class="alert alert-error"><?= e($error) ?></div>
    <?php endif; ?>

    <form method="post" class="form-grid">
        <div>
            <label>Username
                <input name="username" required autofocus value="<?= e($_POST['username'] ?? '') ?>">
            </label>
        </div>
        <div>
            <label>Password
                <input type="password" name="password" required>
            </label>
        </div>
        <div class="full">
            <button class="button" type="submit">Sign in</button>
        </div>
    </form>
</section>

<?php require __DIR__ . '/../includes/footer.php'; ?>