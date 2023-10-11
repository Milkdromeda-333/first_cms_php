<?php

require "./includes/database.php";
require "./includes/auth.php";


$conn = connectDB();

session_start();

$sql = "SELECT * FROM article";

$results = mysqli_query($conn, $sql);

if($results === false) {
    echo mysqli_error($conn);
} else {
    $articles = mysqli_fetch_all($results, MYSQLI_ASSOC);
}
?>

<!-- START OUTPUT -->

<?php require "./includes/header.php" ?>

<?php if(isLoggedIn()): ?>
    <p>You are authenticated</p>
    <a href="./logout.php">logout</a>

<?php else: ?>
    <p>You are not logged in!</p>
    <a href="./login.php">login now</a>
<?php endif; ?>

<span>Wanna submit a <a href="./new-article.php">new article?</a> </span>
<?php if($articles): ?>
<?php foreach($articles as $article): ?>
<div>
    <h2> <?= htmlspecialchars($article["title"]) ?> </h2>
    <span> <?= htmlspecialchars($article["published_at"]) ?> </span>
    <a href="./article.php?id=<?= htmlspecialchars($article["id"]); ?>">link</a>
    <a href="./delete-article.php?id=<?= $article["id"] ?>">delete</a>
</div>
<?php endforeach; ?>
<?php else: ?>
<span>No articles!</span>
<?php endif; ?>
<?php require "./includes/footer.php"?>