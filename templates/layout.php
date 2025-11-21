<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title><?=htmlspecialchars($title)?></title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Student Q&amp;A</h1>
        <nav>
            <a href="index.php">Home</a> |
            <?php if (isLoggedIn()): ?>
                <a href="profile.php?username=<?=htmlspecialchars(getCurrentUser()['username'])?>">My Profile</a> |
                <a href="admin/addquestion.php">Add Question</a> |
                <?php if (isAdmin()): ?>
                    <a href="admin/admin_panel.php">Admin Panel</a> |
                <?php endif; ?>
                <a href="contact.php">Contact</a> |
                <span>Hello, <?=htmlspecialchars(getCurrentUser()['name'])?>!</span> |
                <a href="logout.php">Logout</a>
            <?php else: ?>
                <a href="login.php">Login</a> |
                <a href="register.php">Register</a> |
                <a href="contact.php">Contact</a>
            <?php endif; ?>
        </nav>
    </header>
    <main>
        <?=$output?>
    </main>
    <footer>
        &copy; Coursework - small demo
    </footer>
</body>
</html>
