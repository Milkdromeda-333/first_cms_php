<?php

require "./includes/article.php";
require "./classes/User.php";
require "./classes/Database.php";


session_start();

if($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $db = new Database();
    $conn = $db->getConn();
    
    if(User::authenticate($conn, $_POST["username"], $_POST["password"])){
        session_regenerate_id(true); // deletes old session id to prevent session fixation attacks
        $_SESSION["is_logged_in"] = true;
        relocate("hello");
    } else {
        $error = "Login is incorrect";
    }
}

?>

<?php require "./includes/header.php" ?>
<h1>Login!</h1>
<form method="POST" action="./login.php">
    <?php require "./includes/auth-form.php" ?>
    <button>Login</button>
    <a href="./hello.php">back home</a>
    <a href="./sign-up.php">sign up</a>

</form>
<?php require "./includes/footer.php" ?>
