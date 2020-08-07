<?php

require_once __DIR__ . "/db.php";

function userIsLogged()
{
    $db = new DB();

    if (isset($_COOKIE["id"]) and isset($_COOKIE["hash"])) {
        $user = $db->getUser(intval($_COOKIE["id"]));
        if ($user and $user["id"] == $_COOKIE["id"] and $user["hash"] == $_COOKIE["hash"]) {
            return true;
        }
    }
    return false;
}

