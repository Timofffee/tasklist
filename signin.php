<?php

require_once __DIR__ . "/check.php";
require_once __DIR__ . "/db.php";

if (userIsLogged())
    header('Location: /');

$incorrect_pass = 0;

if (isset($_POST["submit"])) {
    if(!empty($_POST["login"]) and !empty($_POST["login"])) {
        $db = new DB();
        $user = $db->getUser($_POST["login"]);
        if ($user) { # exisits
            if (password_verify($_POST["pass"], $user["password"])) {
                setcookie("id", $user["id"], time()+60*60*24*30, "/", null, null, true);
                header('Location: /');
            } else { # pass incorrect
                $incorrect_pass = 2;
            }
        } else { #new user?
            $id = $db->query(
                "INSERT INTO users (login, password) VALUES (:login, :pass)", [
                    "login" => $_POST["login"],
                    "pass" => password_hash($_POST["pass"], PASSWORD_DEFAULT, array("cost" => 10))
                 ]
            );
            if ($id) {
                setcookie("id", $id, time()+60*60*24*30, "/", null, null, true);
                header('Location: /');
            }
        }
    } else {
        $incorrect_pass = 1;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Sign in | Task list</title>
</head>
<body>
    <body>
        <div class="container">
            <h1>Sign in</h1>
            <form action="" method="post">
                <input type="text" placeholder="Login" name="login">
                <input type="password" placeholder="Password" name="pass">
                <?php if ($incorrect_pass == 1): ?> 
                    <p> Fill in all fields </p>
                <? elseif ($incorrect_pass == 2): ?>
                    <p> Incorrect password </p>
                <? endif; ?>
                <input type="submit" value="Login" name="submit">
            </form>
        </div>
        
    </body>
</body>
</html>