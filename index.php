<?php

require_once __DIR__ . "/app/model.php";
require_once __DIR__ . "/templates/index_tmpl.php";

$u = new UserModel();
$t = new TaskModel();

if (isset($_GET["logout"])) {
    setcookie("id", time() - 3600);
    setcookie("hash", time() - 3600);
    header('Location: /signin.php');
}

if (!$u->isLogged()) {
    header('Location: /signin.php');
}

if (isset($_POST["add"]) and !empty($_POST["desc"])) { # add task
    $t->add($_POST["desc"]);
    header('Location: /');
}

if (isset($_POST["del"])) { # del task
    $t->delete($_POST["del"]);
    header('Location: /');
}

if (isset($_POST["done"])) { # done task
    $t->done($_POST["done"]);
    header('Location: /');
}

render_page($t->getAll());
?>
