<?php

require_once __DIR__ . "/App/Model.php";
require_once __DIR__ . "/App/View/signinView.php";

$u = new UserModel();

if ($u->isLogged())
    header('Location: /');

$incorrect_pass = 0;

if (isset($_POST["submit"])) {
    if(!empty($_POST["login"]) and !empty($_POST["login"])) {
        if ($u->has($_POST["login"])) { # exisits 
            $user = $u->login($_POST["login"], $_POST["pass"]);
            if ($user) {
                setcookie("id", $user["id"], time()+60*60*24*30, "/", null, null, true);
                setcookie("hash", $user["hash"], time()+60*60*24*30, "/", null, null, true);
                header('Location: /');
            } else { # pass incorrect
                $incorrect_pass = 2;
            }
        } else { #new user?
            $user = $u->reg($_POST["login"], $_POST["pass"]);
            if ($user) {
                setcookie("id", $user["id"], time()+60*60*24*30, "/", null, null, true);
                setcookie("hash", $user["hash"], time()+60*60*24*30, "/", null, null, true);
                header('Location: /');
            }
        }
    } else {
        $incorrect_pass = 1;
    }
}

render_page($incorrect_pass);
?>