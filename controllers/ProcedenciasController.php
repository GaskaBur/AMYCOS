<?php

class ProcedenciasController extends SimpleController {
	
	public $twig;

	function __construct($_twig) {
		$this->twig = $_twig;
		parent::__construct('Procedencia','ProcedenciasController',$_twig);
				
	}		

}

?>