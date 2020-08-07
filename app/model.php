<?php

require_once __DIR__ . "/db.php";

abstract class Model 
{
    private $db;

    public function __construct() 
    {
        $this->$db = new DB();
    }

}

class UserModel extends Model 
{    
    public function isLogged()
    {   
        if (isset($_COOKIE["id"]) and isset($_COOKIE["hash"])) {
            $user = $this->getCurrent();
            if ($user and $user["id"] == $_COOKIE["id"] and $user["hash"] == $_COOKIE["hash"]) {
                return true;
            }
        }
        return false;
    }

    public function getCurrent() 
    {          
        $sql = "SELECT * FROM users WHERE id = :id LIMIT 1";
        return $this->$db->getRow($sql, [
            "id" => intval($_COOKIE["id"])
        ]);
        return false;
    }

    public function get($id) 
    {          
        $sql = "SELECT * FROM users WHERE id = :id LIMIT 1";
        return $this->$db->getRow($sql, [
            "id" => intval($id)
        ]);
        return false;
    }

    public function has($login) 
    {
        $user = $this->$db->getRow(
            "SELECT * FROM users WHERE login = :login LIMIT 1", [
                "login" => htmlspecialchars($login, ENT_QUOTES, 'UTF-8')
            ]
        );
        return boolval($user);
    }

    public function login($login, $pass) 
    {
        $user = $this->$db->getRow(
            "SELECT * FROM users WHERE login = :login LIMIT 1", [
                "login" => htmlspecialchars($login, ENT_QUOTES, 'UTF-8')
            ]
        );
        if ($user) {
            if (password_verify($pass, $user["password"])) {
                return ["id" => $user["id"], "hash" => $user["hash"]];
            }
        }
        return false;
    }

    public function reg($login, $pass) 
    {
        $hash = hash("joaat", rand());
        $id = $this->$db->query(
            "INSERT INTO users (login, password, hash) VALUES (:login, :pass, :hash)", [
                "login" => htmlspecialchars($login, ENT_QUOTES, 'UTF-8'),
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
}

class TaskModel extends Model 
{ 
    public function add($desc) 
    {
        $u = new UserModel();
        if ($u->isLogged()) {
            return $this->$db->query(
                "INSERT INTO tasks (user_id, description) VALUES (:id, :desc)", [
                    "id" => htmlspecialchars($_COOKIE["id"], ENT_QUOTES, 'UTF-8'), 
                    "desc" => htmlspecialchars($desc, ENT_QUOTES, 'UTF-8')
                ]
            );
        }
    }

    public function delete($id) 
    {
        $u = new UserModel();
        if ($u->isLogged()) {
            return $this->$db->query(
                "DELETE FROM tasks WHERE id = :id and user_id = :user_id", [
                    "id" => htmlspecialchars($_POST["task"], ENT_QUOTES, 'UTF-8'),
                    "user_id" => $_COOKIE["id"]
                ]
            );
        }
    }

    public function done($id) 
    {
        $u = new UserModel();
        if ($u->isLogged()) {
            $this->$db->query(
                "UPDATE tasks SET status=1 WHERE id = :id and user_id = :user_id", [
                    "id" => htmlspecialchars($_POST["task"], ENT_QUOTES, 'UTF-8'),
                    "user_id" => $_COOKIE["id"]
                ]
            );
        }
    }

    public function getAll() {
        $u = new UserModel();
        if ($u->isLogged()) {
            $tasks = $this->$db->getAllRows("SELECT * FROM tasks WHERE user_id = :id", [
                "id" => $_COOKIE["id"]
            ]);
            return $tasks;
        } 
        return false;
    }
}

