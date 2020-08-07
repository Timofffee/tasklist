<?php

require_once __DIR__ . "/app/model.php";
require_once __DIR__ . "/templates/index_tmpl.php";

$m = new Model();

if (isset($_GET["logout"])) {
    setcookie("id", time() - 3600);
    setcookie("hash", time() - 3600);
    header('Location: /signin.php');
}

if (!$m->userIsLogged()) {
    header('Location: /signin.php');
}

if (isset($_POST["add"]) and !empty($_POST["desc"])) { # add task
    $m->addTask($_POST["desc"]);
    header('Location: /');
}

if (isset($_POST["del"])) { # del task
    $m->delTask($_POST["del"]);
    header('Location: /');
}

if (isset($_POST["done"])) { # done task
    $m->doneTask($_POST["done"]);
    header('Location: /');
}


render_page($m->getTasks());
?>
