<?php 
require "./includes/init.php";

Auth::requireLogin();

$article = new Article();

if($_SERVER["REQUEST_METHOD"] === "POST") {
    $conn = require "./includes/db.php";

    $article->title = $_POST["title"];
    $article->content = $_POST["content"];
    $article->published_at = $_POST["published_at"];

        
    if($article->createArticle($conn)){
        
        naviagteToArticle($article->id);
    }
}

?>

<!-- START OUTPUT -->

<h2>New article</h2>

<form method="post">
    <?php require "./includes/article-form.php" ?>
    <button>Add+</button>
</form>
<a href="./hello.php">home</a>

<?php require "./includes/footer.php" ?>