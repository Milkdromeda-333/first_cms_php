<?php

require "./includes/init.php";

Auth::logOut();
Url::relocate("hello");