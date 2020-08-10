<?php

class AuthController extends Controller
{

    public function __construct()
    {
        $this->model = new AuthModel();
        $this->view = new View();
    }
    

    public function index()
    {
        if ($this->model->isLogged()) {
            // $this->view->view('index_view.php', 'base_view.php');
            header('Location: /');
        } else {
            $this->view->view('signin_view.php', 'base_view.php');
        }
    }
    

    public function auth()
    {
        $data = $this->model->auth($_POST);
        if ($data[0]) {
            // $this->view->view('index_view.php', 'base_view.php');
            header('Location: /');
        } else {
            $this->view->view(
                'signin_view.php', 
                'base_view.php', [
                    'login' => $_POST['login'], 
                    'pass' => $_POST['pass'], 
                    'error' => $data[1]
                ]
            );
        }
    }

    public function logout()
    {
        $this->model->logout();
        header('Location: /');
        // $this->view->view('signin_view.php', 'base_view.php');
    }
}

