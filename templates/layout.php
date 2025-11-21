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
            <a href="admin/addquestion.php">Add Question</a>
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
