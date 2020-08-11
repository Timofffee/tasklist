<?php

class TaskController extends Controller
{  

    public function index()
    {
        $task = new TaskModel();
        if ($task->isLogged()) {
            View::view('index', 'base', ($tasks) ? $tasks : []);
        } else {
            header('Location: /auth');
            // $this->view->view('signin', 'base');
        }
    }

    public function update() {
        $task = new TaskModel();
        $data = $_POST;
        if ($task->isLogged()) {
            if (isset($data["add"]) and !empty($data["desc"])) {
                $task->add($_POST);
            } elseif (isset($data["del"])) {
                $task->delete($_POST);
            } elseif (isset($data["done"])) {
                $task->done($_POST);
            }
            $tasks = $task->getAll();
            View::view('index', 'base', ($tasks) ? $tasks : []);
        } else {
            header('Location: /auth');
        }
    }
}
