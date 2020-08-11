<?php

function loadModel($class) {
    
    if (file_exists(MODELS_PATH . $class .'.php')) {
        require_once MODELS_PATH . $class .'.php';
    } elseif (file_exists(CONTROLLERS_PATH . $class .'.php')) {
        require_once CONTROLLERS_PATH . $class .'.php';
    }
}

function loadController($class) {
    
}

spl_autoload_register('loadModel');
spl_autoload_register('loadController');