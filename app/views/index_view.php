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
                include 'app/views/task_view.php';
            } ?>
        </div>
    </form>
    <a href="/auth/logout">Logout</a>
</div>
