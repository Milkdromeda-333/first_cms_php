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

    /**
     * Restricts unauthorized users by causing the app to die
     * 
     * @return void
     */
    public static function requireLogin() {
        if(! static::isLoggedIn()) {
            die("Unauthorized");
        }
    }

    /**
     * sets app state to "logged in"
     * 
     * @return void
     */
    public static function logIn() { 
        // deletes old session id to prevent session fixation attacks
        session_regenerate_id(true);

        $_SESSION["is_logged_in"] = true;
    }

    public static function logOut() {
        // Unset all of the session variables.
        $_SESSION = array();

        // If it's desired to kill the session, also delete the session cookie.
        // Note: This will destroy the session, and not just the session data!
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Finally, destroy the session.
        session_destroy();
    }
}