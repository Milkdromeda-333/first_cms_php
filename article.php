<?php

require "./includes/database.php";
require "./includes/article.php";

$conn = connectDB();

if(isset($_GET["id"])) {
    $article = getArticleById($_GET["id"], $conn);
} else {
    $article = null;
}

?>

<!-- START OUTPUT -->

<?php require "./includes/header.php" ?>

<?php if($article != null): ?>

<h2><?= htmlspecialchars($article["title"]) ?></h2>
<span><?= htmlspecialchars($article["published_at"]) ?></span>
<p><?= htmlspecialchars($article["content"]) ?></p>
<a href="./hello.php">back</a>
<a href="./edit-article.php?id=<?= $article["id"] ?>">edit</a>

<?php else: ?>

<p>No article was found!</p>
<a href="./hello.php">back</a>

<?php endif; ?>


<?php require "./includes/footer.php"?>