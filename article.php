<?php

require "./includes/init.php";

$conn = require "./includes/db.php";

if(isset($_GET["id"])) {
    $article = Article::getById($conn, $_GET["id"]);
} else {
    $article = null;
}

?>

<!-- START OUTPUT -->

<?php require "./includes/header.php" ?>

<?php if($article): ?>

<h2><?= htmlspecialchars($article->title) ?></h2>
<span><?= htmlspecialchars($article->published_at) ?></span>
<p><?= htmlspecialchars($article->content) ?></p>
<a href="./hello.php">back</a>
<a href="./edit-article.php?id=<?= $article->id ?>">edit</a>

<?php else: ?>

<p>No article was found!</p>
<a href="./hello.php">back</a>

<?php endif; ?>


<?php require "./includes/footer.php"?>