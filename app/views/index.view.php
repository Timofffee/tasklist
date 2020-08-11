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
            foreach ($data as $task) { 
                include VIEWS_PATH . 'task' . VIEW_EXT;
            } ?>
        </div>
    </form>
    <a href="/logout">Logout</a>
</div>
