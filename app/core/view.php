<?php

class View
{
    
    public function __construct() {
        //
    }

    static function view($content_view, $template_view = 'base', $data = null)
    {
        include VIEWS_PATH . $template_view . VIEW_EXT;
    }
    

    
}