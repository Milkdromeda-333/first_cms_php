<?php 

include "./includes/database.php";
include "./includes/article.php";
require "./classes/Article.php";
include "./classes/Database.php";


if(isset($_GET["id"])) {
    $db = new Database();
    $conn = $db->getConn();
    $id = $_GET["id"];

    $article = Article::getById($conn, $id);

    if(!$article) {
        die("No article found");
    }
    
    if($_SERVER["REQUEST_METHOD"] === "POST") {
        $article->title = $_POST["title"];
        $article->content = $_POST["content"];
        $article->published_at = $_POST["published_at"];

            
        if($article->updateArticle($conn)){
            naviagteToArticle($article->id);
        }
    }
}

    
?>

<h1>Edit Article</h1>

<?php if($article != null): ?>

<form method="POST">
    <?php require "./includes/article-form.php" ?>
    <button>Save</button>
    <a href="/first_cms_php/article.php?id=<?= $article->id?>">go back</a>
</form>

<?php else: ?>

<span>No article found..</span>

<?php endif; ?>

<a href="./hello.php">go home</a>