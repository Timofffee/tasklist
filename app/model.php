<?php

require_once __DIR__ . "/db.php";

class Model 
{
    private $db;

    function __construct() 
    {
        $this->$db = new DB();
    }

    function userIsLogged()
    {   
        if (isset($_COOKIE["id"]) and isset($_COOKIE["hash"])) {
            $user = $this->getCurrentUser();
            if ($user and $user["id"] == $_COOKIE["id"] and $user["hash"] == $_COOKIE["hash"]) {
                return true;
            }
        }
        return false;
    }

    function getCurrentUser() 
    {          
        $sql = "SELECT * FROM users WHERE id = :id LIMIT 1";
        return $this->$db->getRow($sql, [
            "id" => intval($_COOKIE["id"])
        ]);
        return false;
    }

    function getUser($id) 
    {          
        $sql = "SELECT * FROM users WHERE id = :id LIMIT 1";
        return $this->$db->getRow($sql, [
            "id" => intval($id)
        ]);
        return false;
    }

    function hasUser($login) {
        $user = $this->$db->getRow(
            "SELECT * FROM users WHERE login = :login LIMIT 1", [
                "login" => $login
            ]
        );
        return boolval($user);
    }

    function loginUser($login, $pass) 
    {
        $user = $this->$db->getRow(
            "SELECT * FROM users WHERE login = :login LIMIT 1", [
                "login" => $login
            ]
        );
        if ($user) {
            if (password_verify($pass, $user["password"])) {
                return ["id" => $user["id"], "hash" => $user["hash"]];
            }
        }
        return false;
    }

    function regUser($login, $pass) 
    {
        $hash = hash("joaat", rand());
        $id = $this->$db->query(
            "INSERT INTO users (login, password, hash) VALUES (:login, :pass, :hash)", [
                "login" => $login,
                "pass" => password_hash(
                    $pass, 
                    PASSWORD_DEFAULT, 
                    array("cost" => 10)
                ),
                "hash" => $hash
             ]
        );
        if ($id) {
            return ["id" => $id, "hash" => $hash];
        }
        return false;
    }

    function addTask($desc) 
    {
        if ($this->userIsLogged()) {
            return $this->$db->query(
                "INSERT INTO tasks (user_id, description) VALUES (:id, :desc)", [
                    "id" => htmlspecialchars($_COOKIE["id"], ENT_QUOTES, 'UTF-8'), 
                    "desc" => htmlspecialchars($desc, ENT_QUOTES, 'UTF-8')
                ]
            );
        }
    }

    function delTask($id) 
    {
        if ($this->userIsLogged()) {
            return $this->$db->query(
                "DELETE FROM tasks WHERE id = :id and user_id = :user_id", [
                    "id" => htmlspecialchars($_POST["task"], ENT_QUOTES, 'UTF-8'),
                    "user_id" => $_COOKIE["id"]
                ]
            );
        }
    }

    function doneTask($id) 
    {
        if ($this->userIsLogged()) {
            $this->$db->query(
                "UPDATE tasks SET status=1 WHERE id = :id and user_id = :user_id", [
                    "id" => htmlspecialchars($_POST["task"], ENT_QUOTES, 'UTF-8'),
                    "user_id" => $_COOKIE["id"]
                ]
            );
        }
    }

    function getTasks() {
        if ($this->userIsLogged()) {
            return $this->$db->getAllRows("SELECT * FROM tasks WHERE user_id = :id", [
                "id" => $_COOKIE["id"]
            ]);
        } 
        return false;
    }
}

