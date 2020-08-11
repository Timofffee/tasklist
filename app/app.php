<?php 

require_once 'bootstrap.php';

class App 
{
    public function __destruct() 
    {
        if ($GLOBALS['route'] != null) {
            $this->run();
        } else {
            Route::ErrorPage404();
        }
    }

    public function run() 
    {
        call_user_func_array([
            new $GLOBALS['route'][0], 
            $GLOBALS['route'][1]
        ], $GLOBALS['route'][2]
        );
    }

}