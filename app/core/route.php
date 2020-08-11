<?php

class Route
{
    static function start()
    {
        $basename = 'Task';
        $action = 'index';
        
        $routes = explode('/', $_SERVER['REQUEST_URI']);

        if (!empty($routes[1]) and $routes[1] == '404') {
            View::view('errors/404');
            exit();
        }

        $basename = empty($routes[1]) ? $basename : $routes[1];
        $action = empty($routes[2]) ? $action : $routes[2];

        // $model_name = $basename.'Model';
        // $controller_name = $basename.'Controller';

        // $model_file = strtolower($model_name).'.php';
        // $model_path = "app/models/".$model_file;
        // if(file_exists($model_path)) {
        //     include "app/models/".$model_file;
        // }

        $controller_class = $basename.'Controller';

        $controller_file = $controller_class . '.php';
        if(!file_exists(CONTROLLERS_PATH . $controller_file)) {
            Route::ErrorPage404();
        } 

        $controller = new $controller_class;
        
        if(method_exists($controller, $action)) {
            $controller->$action();
        } else {
            Route::ErrorPage404();
        }
    
    }
    

    static function ErrorPage404()
    {
        $host = 'http://'.$_SERVER['HTTP_HOST'].'/';
        header('HTTP/1.1 404 Not Found');
        header("Status: 404 Not Found");
        header('Location:'.$host.'404');
    }
}