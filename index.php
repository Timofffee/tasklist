<?php

require_once __DIR__ . "/check.php";
require_once __DIR__ . "/db.php";

if (isset($_GET["logout"])) {
    setcookie("id", time() - 3600);
    header('Location: /signin.php');
}

if (!userIsLogged()) {
    header('Location: /signin.php');
}

$db = new DB();

{ # add task
    if (isset($_POST["add"]) and !empty($_POST["desc"])) {
        $task = $db->query(
            "INSERT INTO tasks (user_id, description) VALUES (:id, :desc)", [
                "id" => htmlspecialchars($_COOKIE["id"], ENT_QUOTES, 'UTF-8'), 
                "desc" => htmlspecialchars($_POST["desc"], ENT_QUOTES, 'UTF-8')
            ]
        );
        header('Location: /');
    }
}

{ # del task
    if (isset($_POST["del"])) {
        $task = $db->query(
            "DELETE FROM tasks WHERE id = :id", [
                "id" => htmlspecialchars($_POST["task"], ENT_QUOTES, 'UTF-8')
            ]
        );
        header('Location: /');
    }
}

{ # done task
    if (isset($_POST["done"])) {
        $task = $db->query(
            "UPDATE tasks SET status=1 WHERE id = :id", 
            ["id" => htmlspecialchars($_POST["task"], ENT_QUOTES, 'UTF-8')]
        );
        header('Location: /');
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Task list</title>
</head>
<body>
    <body>
        <div class="container">
            <h1>Task list</h1>
            <form action="/" method="post">
                <div class="buttons">
                    <input type="text" name="desc" placeholder="New task">
                    <input type="submit" value="Add" name="add">
                    <input type="submit" value="Delete" name="del">
                    <input type="submit" value="Done" name="done">
                </div>
                <div class="tasks">
                    <?php
                    $rows = $db->getAllRows("SELECT * FROM tasks WHERE user_id = :id", [
                        "id" => $_COOKIE["id"]
                    ]);
                    foreach ($rows as $row) { 
                        $task = "task".$row["id"];
                        ?>
                            <div class="row task <?=($row["status"]) ? "done" : ""?>">
                                <input type="radio" name="task" id="<?=$task?>" value="<?=$row["id"]?>">
                                <label for="<?=$task?>"><?=$row["description"]?></label>
                            </div>
                    <? } ?>
                </div>
            </form>
            <a href="/?logout=1">Logout</a>
        </div>
        
    </body>
</body>
</html>