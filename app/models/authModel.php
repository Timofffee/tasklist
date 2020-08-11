<?php

class AuthModel extends Model 
{    
    public function get() 
    {          
        $sql = "SELECT * FROM users WHERE id = :id LIMIT 1";
        return $this->$db->getRow($sql, [
            "id" => intval($_COOKIE["id"])
        ]);
        return false;
    }


    public function find($id) 
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
                setcookie("id", $user["id"], time()+60*60*24*30, "/", null, null, true);
                setcookie("hash", $user["hash"], time()+60*60*24*30, "/", null, null, true);
                return true;
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
            setcookie("id", $id, time()+60*60*24*30, "/", null, null, true);
            setcookie("hash", $hash, time()+60*60*24*30, "/", null, null, true);
            return true;
        }
        return false;
    }


    public function auth($data) {
        $error = 0;
        $success = false;

        if (isset($data["submit"])) {
            if(!empty($data["login"]) and !empty($data["login"])) {
                if ($this->has($data["login"])) { # exisits 
                    if ($this->login($data["login"], $data["pass"])) {
                        $success = true;
                    } else { # pass incorrect
                        $error = 2;
                    }
                } else { #new user?
                    if ($this->reg($data["login"], $data["pass"])) {
                        $success = true;
                    }
                }
            } else {
                $error = 1;
            }
        }
        return [$success, $error];
    }

    public function logout() {
        setcookie("id", "000", time() - 3600, "/");
        setcookie("hash", "000", time() - 3600, "/");
    }
}