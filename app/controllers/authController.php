<?php

class AuthController extends Controller
{

    public function index()
    {
        $auth = new AuthModel();
        if ($auth->isLogged()) {
            // View::view('index');
            header('Location: /');
        } else {
            View::view('signin');
        }
    }
    

    public function auth()
    {
        $auth = new AuthModel();
        $data = $auth->auth($_POST);
        if ($data[0]) {
            // View::view('index');
            header('Location: /');
        } else {
            View::view('signin', 'base', [
                'login' => $_POST['login'], 
                'pass' => $_POST['pass'], 
                'error' => $data[1]
            ]);
        }
    }

    public function logout()
    {
        $auth = new AuthModel();
        $auth->logout();
        header('Location: /');
        // View::view('signin');
    }
}

