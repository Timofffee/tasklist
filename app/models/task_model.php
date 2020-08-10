<?php

class TaskModel extends Model 
{ 
    public function add($data) 
    {
        return $this->$db->query(
            "INSERT INTO tasks (user_id, description) VALUES (:id, :desc)", [
                "id" => htmlspecialchars($_COOKIE["id"], ENT_QUOTES, 'UTF-8'), 
                "desc" => htmlspecialchars($data["desc"], ENT_QUOTES, 'UTF-8')
            ]
        );
}


    public function delete($data) 
    {   
        return $this->$db->query(
            "DELETE FROM tasks WHERE id = :id and user_id = :user_id", [
                "id" => htmlspecialchars($data["task"], ENT_QUOTES, 'UTF-8'),
                "user_id" => $_COOKIE["id"]
            ]
        );
    }


    public function done($data) 
    {
        return $this->$db->query(
            "UPDATE tasks SET status=1 WHERE id = :id and user_id = :user_id", [
                "id" => htmlspecialchars($data["task"], ENT_QUOTES, 'UTF-8'),
                "user_id" => $_COOKIE["id"]
            ]
        );
    }


    public function getAll() {
        $tasks = $this->$db->getAllRows("SELECT * FROM tasks WHERE user_id = :id", [
            "id" => $_COOKIE["id"]
        ]);
        return ($tasks) ? $tasks : false;
    }
}