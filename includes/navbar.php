<?php 
    $session = session_status() === PHP_SESSION_ACTIVE ? $_SESSION : [];
    $isLoggedIn = !empty($session['user_id']);
?>

<?php if ($isLoggedIn): ?>
<header class="site-header site-header--auth">
    <nav class="container nav" aria-label="Main navigation">
        <a class="brand" href="<?= BASE_URL ?>/dashboard/index.php">Library LMS</a>
        <div class="nav-links">
            <a href="<?= BASE_URL ?>/books/index.php">Books</a>
            <a href="<?= BASE_URL ?>/members/index.php">Members</a>
            <a href="<?= BASE_URL ?>/loans/index.php">Loans</a>
            <a href="<?= BASE_URL ?>/authors/index.php">Authors</a>
            <a href="<?= BASE_URL ?>/categories/index.php">Categories</a>
            <a href="<?= BASE_URL ?>/auth/logout.php">Logout</a>
        </div>
    </nav>
</header>
<?php endif; ?>