<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
    <title>Sign in</title>
</head>
<body>
    <main class="page">
        <div class="container" style="max-width: 480px">
            <section class="card">
                <h1>Library Management System</h1>
                <p class="muted">Sign in with your librarian account.</p>
                
                <form method="post">
                    <p><label>Username
                        <input name="username" required value="<?= e(post('username')) ?>">
                    </label></p>
                    <p><label>Password
                        <input type="password" name="password" required>
                    </label></p>
                    <button class="button">Sign in</button>
                </form>
                <p class="muted">Test account: admin / password</p>
            </section>
        </div>
    </main>
</body>
</html>