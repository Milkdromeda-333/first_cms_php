<?php

class Url 
{
    /**
     * Navigates a user to a page
     * 
     * @param string endpoint of url where user will be navigated to
     * @return string sends a header back that will navigate a user to specified url
     */
    public static function relocate($location)
    {
        return header("Location: ./$location.php");
    }
}