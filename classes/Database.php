<?php 

/**
 * Database
 * 
 * A connection to the database
 */
class Database 
{
    /**
     * Get the dtabase connection
     * 
     * @return PDO object Connection to the database server
     */
    public function getConn() 
    {
        $db_host = "localhost";
        $db_name = "cms";
        $db_user = "";
        $db_pass = "";

        $dsn = 'mysql:host=' . $db_host . ';dbname=' . $db_name . ';charset=utf8';

        try{
            return new PDO($dsn, $db_user, $db_pass, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        }catch (PDOException $e){
            echo $e->getMessage();
            exit;
        }
    }
}