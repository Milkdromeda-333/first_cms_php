<?php

session_start();

if($_SERVER["REQUEST_METHOD"] === "POST") {
    if($_POST["username"] === "secret" && $_POST["password"] === "secret"){
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
<form method="POST" action="/login.php">
    <?php if(!empty($error)): ?>
        <span>Wrong credentials!</span>
    <?php endif; ?>
    <div>
        <label for="username">username:</label>
        <input type="username" id="username" name="username">
    </div>

    <div>
        <label for="password">password:</label>
        <input type="password" id="password" name="password">
    </div>
    <button>Login</button>
    <a href="./hello.php">back home</a>
</form>
<?php require "./includes/footer.php" ?>
