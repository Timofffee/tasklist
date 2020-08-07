<?php

require_once __DIR__ . "/db.php";

function userIsLogged()
{
    $db = new DB();

    if (isset($_COOKIE["id"]) and $_COOKIE["id"] > 0) {
        $user = $db->getUser(intval($_COOKIE["id"]));
        if ($user and $user["id"] == $_COOKIE["id"]) {
            return true;
        }
    }
    return false;
}

