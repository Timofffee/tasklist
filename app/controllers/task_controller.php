<?php

class TaskController extends Controller
{

    public function __construct()
    {
        $this->model = new TaskModel();
        $this->view = new View();
    }
    

    public function index()
    {
        $data = $_POST;
        if ($this->model->isLogged()) {
            if (isset($data["add"]) and !empty($data["desc"])) {
                $this->model->add($_POST);
            } elseif (isset($data["del"])) {
                $this->model->delete($_POST);
            } elseif (isset($data["done"])) {
                $this->model->done($_POST);
            }
            $tasks = $this->model->getAll();
            $this->view->view('index_view.php', 'base_view.php', ($tasks) ? $tasks : []);
        } else {
            header('Location: /auth');
            // $this->view->view('signin_view.php', 'base_view.php');
        }
    }
}
