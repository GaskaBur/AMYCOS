<?php

class ClasesController extends SimpleController {

	
	public $twig;

	function __construct($twig) {
		$this->twig = $twig;
		parent::__construct('Clase','ClasesController',$twig);
				
	}

		

}

?>