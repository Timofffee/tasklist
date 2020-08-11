<div class="row task <?=($task["status"]) ? "done" : ""?>">
    <input type="radio" name="task" id="<?="task".$task["id"]?>" value="<?=$task["id"]?>">
    <label for="<?="task".$task["id"]?>"><?=$task["description"]?></label>
</div>