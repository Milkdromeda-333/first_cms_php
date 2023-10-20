<?php

class Auth {
    /**
     * Return wether user is logged in
     * 
     * @return boolean True if user is logged in, false if user is not logged in
     */
    public static function isLoggedIn() {
        return isset($_SESSION["is_logged_in"]) && $_SESSION["is_logged_in"];
    }
}