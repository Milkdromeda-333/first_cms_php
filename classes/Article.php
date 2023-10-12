<?php


class Article
{
    public $id;
    public $title;
    public $content;
    public $published_at;
    public $errors = [];


/**
 * Get all articles
 * @param object $conn connection to database
 * 
 * @return array associative array of all articles
 */
    public static function getAll($conn) 
    {
        $sql = "SELECT * 
            FROM article
            ORDER BY published_at;";

            $results = $conn->query($sql);

            return $results->fetchAll();
    }

    /**
     * Gets an article by id
     * 
     * @param integer an object id
     * @return mixed an object if the sql query was successful, or null i think
     */
    public static function getById($conn, $id, $columns = "*") 
    {
        $sql = "SELECT $columns 
            FROM article
            WHERE id = :id
            ;";

            $stmt = $conn->prepare($sql);

            $stmt->bindValue(':id', $id, PDO::PARAM_INT);

            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Article');

            if($stmt->execute()) {
                return $stmt->fetch();
            }
    }

    /**
     * Updates an article instance
     * 
     * @param object a connection object
     * @return boolean wether article was successfully updated or not
     */
    public function updateArticle($conn) 
    {
        if($this->validateArticle()){
            $sql = "UPDATE article 
                SET title = :title, 
                    content = :content, 
                    published_at = :published_at 
                WHERE id = :id";

            $stmt = $conn->prepare($sql);

            $stmt->bindValue(":id", $this->id, PDO::PARAM_INT);
            $stmt->bindValue(":title", $this->title, PDO::PARAM_STR);
            $stmt->bindValue(":content", $this->content, PDO::PARAM_STR);
            
            if($this->published_at == "") {
                $stmt->bindValue(":published_at", null, PDO::PARAM_NULL);
            } else {
                $stmt->bindValue(":published_at", $this->published_at, PDO::PARAM_STR);
            }

            return $stmt->execute();
        } else {
            return false;
        };
    }

    /**
     * Validates articles
     * 
     * @return boolean wether article is valid or not
     */
    protected function validateArticle() 
    {    
        if($this->title == "") {
            $this->errors[] = "A title is required";
        }

        if($this->content == "") {
            $this->errors[] = "Content is required";
        }

        if($this->published_at != "") {
            $isDateTimeWellFormatted = date_create_from_format("Y-m-d H:i:s", $this->published_at); // checks for correct formatting

            if($isDateTimeWellFormatted === false) {
                $this->errors[] = "Invalid format for date and time";
            } else {
                // ....db may not like the date offered so... we check for more errors. ie impossible date in the right format.

                $date_errors_present = date_get_last_errors();  // check if there was an error from calling date_create_from_format()
            
                if($date_errors_present !== false) {
                    if($date_errors_present["warning_count"] > 0 || $date_errors_present["error_count"] > 0 ) {
                        $this->errors[] = "Invalid date and time";    
                    }
                }
            }
        } else if($this->published_at == "") {
            $this->errors[] = "Date and time are required";
        }

        return empty($this->errors);
    }

    public function deleteArticle($conn) 
    {
        $sql = "DELETE FROM article 
                WHERE id = :id";

        $stmt = $conn->prepare($sql);

        $stmt->bindValue(":id", $this->id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Creates a new article
     * 
     * @param object a connection object
     * @return boolean wether article was successfully posted or not
     */
    public function createArticle($conn) 
    {
        if($this->validateArticle()){
            $sql = "INSERT INTO article (title, content, published_at)
                    VALUES (:title, :content, :published_at)";

            $stmt = $conn->prepare($sql);

            $stmt->bindValue(":title", $this->title, PDO::PARAM_STR);
            $stmt->bindValue(":content", $this->content, PDO::PARAM_STR);
            
            if($this->published_at == "") {
                $stmt->bindValue(":published_at", null, PDO::PARAM_NULL);
            } else {
                $stmt->bindValue(":published_at", $this->published_at, PDO::PARAM_STR);
            }

            if($stmt->execute()) {
                $this->id = $conn->lastInsertId();
                return true;
            }
        } else {
            return false;
        };
    }
}