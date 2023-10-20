<?php 

/**
 * User
 * 
 * A person or entity that can log into the site
 */
class User
{   
    public $id;
    public $username;
    public $password;
    

    /**
     * Authenticate user by username and password
     * 
     * @param string $username user's username
     * @param string $password yser's password
     * 
     * @return boolean true if username and password are tied to an account, otherwise null
     */
    static function authenticate($conn, $username, $password)
    {  
        $sql = " SELECT *
                FROM user
                WHERE username = :username";

        $stmt = $conn->prepare($sql);

        $stmt->bindValue(":username", $username, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_CLASS, "User");

        $stmt->execute();

        if($user = $stmt->fetch()) {
            return $user->$password == $password;
        }
    }

    /**
     * Create a new user in the database
     * 
     * @param object $conn database connection object
     * @param string $username user's username
     * @param string $password user's password
     * 
     * @return boolean true if sign up was successful, false otherwise
     */
    static function signUp($conn, $username, $password)
    {  
            $sql = "SELECT * FROM user WHERE username = :username";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":username", $username, PDO::PARAM_STR);

            if(! $stmt->execute()) { // TEST!!
                return false;
            } else {
                $luckyUser = $stmt->fetch();
                if($luckyUser == null) { // if there is no user with this username
                    $sql = "INSERT INTO user (username, password)
                            VALUES (:username, :password)";

                    $stmt = $conn->prepare($sql);

                    $stmt->bindValue(":username", $username, PDO::PARAM_STR);
                    $stmt->bindValue(":password", $password, PDO::PARAM_STR);

                    if($stmt->execute()) {
                        echo "insert id ";

                        // echo $stmt->lastInsertId(); // isnt working frr

                        return true;
                    }
                } 
                    return false;
                }
            }
        
    }
