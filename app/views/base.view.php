<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/style.css">
    <title><?=empty($title) ? "Task list" : $title ?></title>
</head>
<body>
<?php include VIEWS_PATH . $content_view . VIEW_EXT; ?>
</body>
</html>