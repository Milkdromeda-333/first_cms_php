<?php 
require './includes/header.php'; 
require 'includes/database.php';
require 'includes/article.php';
require 'includes/auth.php';

session_start();
if(!isLoggedIn()) {
    die("unauthorized");
}

$title = "";
$content = "";
$published_at = "";

if($_SERVER["REQUEST_METHOD"] === "POST") {
    $conn = connectDB();

    $title = $_POST["title"];
    $content = $_POST["content"];
    $published_at = $_POST["published_at"];

    $errors = validateArticle($title, $content, $published_at);

    // only run if there are no *handled* errors
    if(empty($errors)) {

        // prepare statment for later use and bnding of values to placeholders
        $stmt = $conn->prepare("INSERT INTO article (title, content, published_at) VALUES (?, ?, ?)");

        // bind values to params/placeholders in prepared statement
        $stmt->bind_param("sss", $title, $content, $published_at);

        // execute...
        if($stmt->execute(  )){
            $id = mysqli_insert_id($conn);

            naviagteToArticle($id);

            exit; // exit so that none of the other code even runs
        } else {
            echo "Error! $stmt->error \n";
            echo $stmt->error;
        }

        $stmt->close();
        $conn->close();

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