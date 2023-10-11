<?php 

include "./includes/database.php";
include "./includes/article.php";

$conn = connectDB();

if($_SERVER["REQUEST_METHOD"] == "POST") { 
    $sql = "DELETE from article WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if($stmt === false) {
        echo mysqli_error($conn);
    } else {
        mysqli_stmt_bind_param($stmt, "i", $_GET["id"]);
        if(mysqli_stmt_execute($stmt)) {
            relocate("hello");
        } else {
            echo "ERROR";
            echo mysqli_stmt_error($stmt);
        }
    }

} else {
        $id = $_GET["id"];
        include "./includes/header.php";
        ?>
        <h2>Delete article?</h2>

        <form method="POST" action="/delete-article.php?id=<?= htmlspecialchars($id); ?>">
            <!-- we have to use POST 
            method because HTTP forms can only use GET and POST-->
            <button>delete</button>
            <a href=".hello.php">cancel</a>
        </form>
        <?php 
        include "./includes/footer.php";
}
?>