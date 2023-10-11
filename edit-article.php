<?php 

include "./includes/database.php";
include "./includes/article.php";

if(isset($_GET["id"])) {
    $conn = connectDB();
    $id = $_GET["id"];
    $article = getArticleById($id, $conn);
    
    if($article != null) {
        $title = $article["title"];
        $content = $article["content"];
        $published_at = $article["published_at"];

        if($_SERVER["REQUEST_METHOD"] === "POST") {
            $title = $_POST["title"];
            $content = $_POST["content"];
            $published_at = $_POST["published_at"];

            $errors = validateArticle($title, $content, $published_at);

            if(empty($errors)) {
                $stmt = mysqli_prepare($conn, "UPDATE article SET title = ?, content = ?, published_at = ? WHERE id = ?");

                if($stmt === false) {
                    echo mysqli_error($conn);
                } else {
                    if($published_at === "") {
                        $published_at = null;
                    }
                    $stmt->bind_param("sssi", $title, $content, $published_at, $id);

                    if($stmt->execute()){
                        naviagteToArticle($id);
                    }
                }

                
            }
        }
    }

} else {
    $article = null;
}

    
?>

<h1>Edit Article</h1>

<?php if($article != null): ?>

<form method="POST">
    <?php require "./includes/article-form.php" ?>
    <button>Save</button>
</form>

<a href="./article.php?id=<?= $article["id"]?>">go back</a>
<?php else: ?>

<span>No article found..</span>

<?php endif; ?>

<a href="./hello.php">go home</a>