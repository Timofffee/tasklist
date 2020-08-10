<?php

function render_task($task) {
    $t = "task".$task["id"]; ?>
    <div class="row task <?=($task["status"]) ? "done" : ""?>">
        <input type="radio" name="task" id="<?=$t?>" value="<?=$task["id"]?>">
        <label for="<?=$t?>"><?=$task["description"]?></label>
    </div>
<? }