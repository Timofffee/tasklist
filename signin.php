<?php

require_once __DIR__ . "/app/model.php";
require_once __DIR__ . "/templates/signin_tmpl.php";

$m = new Model();

if ($m->userIsLogged())
    header('Location: /');

$incorrect_pass = 0;

if (isset($_POST["submit"])) {
    if(!empty($_POST["login"]) and !empty($_POST["login"])) {
        if ($m->hasUser($_POST["login"])) { # exisits 
            $user = $m->loginUser($_POST["login"], $_POST["pass"]);
            if ($user) {
                setcookie("id", $user["id"], time()+60*60*24*30, "/", null, null, true);
                setcookie("hash", $user["hash"], time()+60*60*24*30, "/", null, null, true);
                header('Location: /');
            } else { # pass incorrect
                $incorrect_pass = 2;
            }
        } else { #new user?
            $user = $m->regUser($_POST["login"], $_POST["pass"]);
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

render_page();
?>