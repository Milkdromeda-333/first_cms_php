<?php 

include "./includes/database.php";
include "./includes/article.php";
require 'classes/Database.php';
require 'classes/Article.php';

$db = new Database();
$conn = $db->getConn();

if($_SERVER["REQUEST_METHOD"] == "POST") { 
    $article = Article::getById($conn, $_GET["id"]);
    if($article->deleteArticle($conn)){
        relocate("hello");
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
            <a href=".hello.php">cancel</a>
        </form>
        <?php 
        include "./includes/footer.php";
}
?>