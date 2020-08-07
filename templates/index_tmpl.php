<?php

require_once __DIR__ . "/head_tmpl.php";
require_once __DIR__ . "/task_tmpl.php";


function render_page($tasks=[]) { ?>

    <!DOCTYPE html>
    <html lang="en">
    <? render_head() ?>
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
                        foreach ($tasks as $task) { 
                            render_task($task);
                        } ?>
                    </div>
                </form>
                <a href="/?logout=1">Logout</a>
            </div>
            
        </body>
    </body>
    </html>
<? }
