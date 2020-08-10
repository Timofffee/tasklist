<?php

require_once __DIR__ . "/../db.php";

abstract class Model 
{
    private $db;

    public function __construct() 
    {
        $this->$db = new DB();
    }


    public function isLogged()
    {   
        if (isset($_COOKIE["id"]) and isset($_COOKIE["hash"])) {
            
            $sql = "SELECT * FROM users WHERE id = :id LIMIT 1";
            $user = $this->$db->getRow($sql, [
                "id" => intval($_COOKIE["id"])
            ]);
            if ($user and $user["id"] == $_COOKIE["id"] and $user["hash"] == $_COOKIE["hash"]) {
                return true;
            }
        }
        return false;
    }
}

