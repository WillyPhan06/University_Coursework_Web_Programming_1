<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title><?=htmlspecialchars($title)?></title>
    <?php $navBase = (strpos($_SERVER['PHP_SELF'], '/admin/') !== false) ? '../' : ''; ?>
    <link rel="stylesheet" href="<?= $navBase ?>styles.css">
</head>
<body>
    <header>
        <h1>Student Q&amp;A</h1>
        <nav>
            <a href="<?= $navBase ?>index.php">Home</a> |
            <?php if (isLoggedIn()): ?>
                <a href="<?= $navBase ?>profile.php?username=<?=htmlspecialchars(getCurrentUser()['username'])?>">My Profile</a> |
                <a href="<?= $navBase ?>addquestion.php">Add Question</a> |
                <?php if (isAdmin()): ?>
                    <a href="<?= $navBase ?>admin/admin_panel.php">Admin Panel</a> |
                <?php endif; ?>
                <a href="<?= $navBase ?>contact.php">Contact</a> |
                <span>Hello, <?=htmlspecialchars(getCurrentUser()['name'])?>!</span> |
                <a href="<?= $navBase ?>logout.php">Logout</a>
            <?php else: ?>
                <a href="<?= $navBase ?>login.php">Login</a> |
                <a href="<?= $navBase ?>register.php">Register</a> |
                <a href="<?= $navBase ?>contact.php">Contact</a>
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
