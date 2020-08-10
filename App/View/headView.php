<?php

function render_head($title="") { ?>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <? if (empty($title)): ?>
            <title>Task list</title>
        <? else: ?>
            <title><?=$title ?> | Task list</title>
        <? endif; ?>
    </head>
<? }