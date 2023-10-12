<?php 
require './includes/header.php'; 
require 'includes/database.php';
require 'includes/article.php';
require 'includes/auth.php';
require 'classes/Database.php';
require 'classes/Article.php';

session_start();
if(!isLoggedIn()) {
    die("unauthorized");
}

$article = new Article();

if($_SERVER["REQUEST_METHOD"] === "POST") {
    $db = new Database();
    $conn = $db->getConn();

    $article->title = $_POST["title"];
    $article->content = $_POST["content"];
    $article->published_at = $_POST["published_at"];

        
    if($article->createArticle($conn)){
        
        naviagteToArticle($article->id);
    }

//    $sql =  "INSERT INTO article (title, content, published_at)
//         VALUES ('" . $_POST['title'] . "','"
//                    . $_POST['content'] . "','"
//                    . $_POST['published_at'] . "')";
                       
//     $results = mysqli_query($conn, $sql);

//     if($results == false) {
//         echo mysqli_error($conn);
//     } else {
//         $id = mysqli_insert_id($conn);
//         echo "Inserted record with id: $id";
//     }
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