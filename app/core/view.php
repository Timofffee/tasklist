<?php

class View
{
	//public $template_view; // здесь можно указать общий вид по умолчанию.
	
	public function __construct() {
		//
	}

	function view($content_view, $template_view, $data = null)
	{
		/*
		if(is_array($data)) {
			// преобразуем элементы массива в переменные
			extract($data);
		}
		*/
		
		include 'app/views/'.$template_view;
	}
}