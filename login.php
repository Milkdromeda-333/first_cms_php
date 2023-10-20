<?php

require "./includes/init.php";

if($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $conn = require "./includes/db.php";
    
    if(User::authenticate($conn, $_POST["username"], $_POST["password"])){
        Auth::logIn();
        Url::relocate("hello");
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
