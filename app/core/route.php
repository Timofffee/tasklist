<?php

class Route
{
    static function start()
    {
        $controller_basename = 'Task';
        $action = 'index';
        
        $routes = explode('/', $_SERVER['REQUEST_URI']);

        $controller_basename = empty($routes[1]) ? $controller_basename : $routes[1];
        $action = empty($routes[2]) ? $action : $routes[2];

        $model_name = $controller_basename.'_model';
        $controller_name = $controller_basename.'_controller';

        $model_file = strtolower($model_name).'.php';
        $model_path = "app/models/".$model_file;
        if(file_exists($model_path)) {
            include "app/models/".$model_file;
        }

        $controller_file = strtolower($controller_name).'.php';
        $controller_path = "app/controllers/".$controller_file;
        if(file_exists($controller_path)) {
            include "app/controllers/".$controller_file;
        } else {
            Route::ErrorPage404();
        }
        
        $controller_class = $controller_basename.'Controller';

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