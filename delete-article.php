<?php 

require "./includes/init.php";

$conn = require "./includes/db.php";


if($_SERVER["REQUEST_METHOD"] == "POST") { 
    $article = Article::getById($conn, $_GET["id"]);
    if($article !== false && $article->deleteArticle($conn)){
        Url::relocate("hello");
    };

} else {
        $id = $_GET["id"];
        include "./includes/header.php";
        ?>
        <h2>Delete article?</h2>

        <form method="POST" action="/first_cms_php/delete-article.php?id=<?= htmlspecialchars($id); ?>">
            <!-- we have to use POST 
            method because HTTP forms can only use GET and POST-->
            <button>delete</button>
            <a href="hello.php">cancel</a>
        </form>
        <?php 
        include "./includes/footer.php";
}
?>