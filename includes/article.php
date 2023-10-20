<?php

/**
 * Get an article record based on ID
 * 
 * @param integer $id   id of the article to return
 * @param object  $conn Connection to the database
 * 
 * @return mixed  an associative array containing the article, or null if article was not found 
 */
function getArticleById($id, $conn)
{
    // $sql = "SELECT * FROM article WHERE id =" . $id;
    // return mysqli_query($conn, $sql);

    $sql = "SELECT * 
            FROM article 
            WHERE id = :id
            ";
    $stmt = $conn->prepare($sql);

    
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);

    if($stmt->execute()) {
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

/**
 * Get an article record based on ID
 * 
 * @param integer $id      id of the article to return
 * @param object  $conn    Connection to the database
 * @param string  $columns columns to selet from in db
 * 
 * @return mixed  an associative array containing the article, or null if article was not found 
 */
function getArticle($id, $conn, $columns = "*")
{
    $sql = "SELECT $columns 
            FROM article 
            WHERE id = ?
            ";
    $stmt = mysqli_prepare($conn, $sql);

    if($stmt === false) {
        echo mysqli_error($conn);
    } else {
        mysqli_stmt_bind_param($stmt, "i", $id);

        if(mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            return mysqli_fetch_array($result, MYSQLI_ASSOC);
        }
    }
}


/**
 * Validates articles based on wether all fields are valid
 * 
 * @param string  title        article title, required
 * @param string  content      article content, required
 * @param integer published_at date which the article was published, formatted like (yyyy-mm-dd hh:mm:ss) if not blank
 * 
 * @return mixed  array   return an array of strings that describe the error, or an empty array
 */

function validateArticle($title, $content, $published_at)
{
    $errors = [];
    
    if($title == "") {
        $errors[] = "A title is required";
    }

    if($content == "") {
        $errors[] = "Content is required";
    }

    if($published_at != "") {
        $isDateTimeWellFormatted = date_create_from_format("Y-m-d H:i:s", $published_at); // checks for correct formatting

        if($isDateTimeWellFormatted === false) {
            $errors[] = "Invalid format for date and time";
        } else {
            // ....db may not like the date offered so... we check for more errors. ie impossible date in the right format.

            $date_errors_present = date_get_last_errors();  // check if there was an error from calling date_create_from_format()
        
            if($date_errors_present !== false) {
                if($date_errors_present["warning_count"] > 0 || $date_errors_present["error_count"] > 0 ) {
                    $errors[] = "Invalid date and time";    
                }
            }
        }
    } else if($published_at == "") {
        $errors[] = "Date and time are required";
    }
    return $errors;
}

/**
 * Get an id and redirect to that articles url
 * 
 * @param  integer $id id of article redirecting user to
 * 
 * @return void
 */
function naviagteToArticle($id) 
{
    if(isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] != "off") {
        $protocol = "https";
    } else {
        $protocol = "http";
    }

    header("Location: $protocol://" . $_SERVER["HTTP_HOST"] . "/first_cms_php/article.php?id=$id");
}

