<?php

class ProyectosController extends SimpleController {

	
	public $twig;

	function __construct($_twig) {
		$this->twig = $_twig;
		parent::__construct('Proyecto','ProyectosController',$_twig);
				
	}

		

}

?>