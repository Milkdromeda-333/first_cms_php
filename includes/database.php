<?php
function connectDB(){

    $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

    if(mysqli_connect_error()) {
        echo mysqli_connect_error();
        exit;
    }
    
    return $conn;
}