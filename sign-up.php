<?php

require "./includes/init.php";

if($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $conn = require "./includes/db.php";

    if(User::signUp($conn, $_POST["username"], $_POST["password"])) {
         Url::relocate("hello");
    } else {
        $error = "There was a problem signing you up.";
    }

}
?>

<?php require "./includes/header.php"; ?>
<h1>Sign up</h1>
    <form method="POST" action="./sign-up.php">
        <?php require "./includes/auth-form.php" ?>
        <button>sign up</button>
    <a href="./hello.php">back home</a>
    <a href="./login.php">log in</a>

</form>
<?php require "./includes/footer.php"; ?>
