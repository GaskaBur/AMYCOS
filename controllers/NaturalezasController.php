<?php

class NaturalezasController extends SimpleController {

	
	public $twig;

	function __construct($twig) {
		$this->twig = $twig;
		parent::__construct('Naturaleza','NaturalezasController',$twig);
				
	}

		

}

?>