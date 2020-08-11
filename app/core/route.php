<?php

class Route
{
    
    static function routes($app) {
        foreach (glob(ROUTES_PATH . '*.php') as $filename)
        {
            require_once $filename;
        }
    }
    
    static function get($url, $action, $data=[]) 
    {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') {
            return false;
        }

        Route::make($url, $action, $data);
    }

    static function post($url, $action, $data=[]) 
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            return false;
        }

        Route::make($url, $action, $data);
    }

    static function get_args($r_routes, $s_routes) {
        $args = [];
        
        for ($i=0; $i < count($s_routes); $i++) { 
            if ($r_routes[$i] !== $s_routes[$i]) {
                return false;
            }

            if (substr($s_routes[$i], 0, 1 ) === "{" and
                substr($s_routes[$i], -1 ) === "}"
            ) {
                $args[substr($s_routes[$i], 1, strlen($s_routes[$i])-2)] = $r_routes[$i];
            }
        }
        return $args;
    }

    static function get_controller_action($raw) {
        $r_controller = array_values(array_filter(explode('@', $raw)));

        //TODO Лишняя проверка, которая может
        //TODO стать проблемой? Хм...
        $controller_file = $r_controller[0] . '.php';
        if(!file_exists(CONTROLLERS_PATH . $controller_file)) {
            return false;
        } 

        $controller = new $r_controller[0];

        if(method_exists($controller, $r_controller[1])) {
            return $r_controller;
        } else {
            return false;
        }
    }

    static function make($url, $action, $data=[]) {
        $r_routes = array_values(array_filter(explode('/', $_SERVER['REQUEST_URI'])));
        $s_routes = array_values(array_filter(explode('/', $url)));
        
        if (count($r_routes) != count($s_routes)) {
            return false;
        }
        
        $args = Route::get_args($r_routes, $s_routes);
        if (!is_array($args)) {
            return false;
        }
        
        $r_controller = Route::get_controller_action($action);
        
        if($r_controller) {
            $GLOBALS['route'] = [$r_controller[0], $r_controller[1], array_merge($args, $data)];
        }
    }
    

    static function ErrorPage404()
    {
        // $host = 'http://'.$_SERVER['HTTP_HOST'].'/';
        header('HTTP/1.1 404 Not Found');
        header("Status: 404 Not Found");
        // header('Location:'.$host.'404');
        View::view('errors/404');
        exit();
    }
}