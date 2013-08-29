<?php

class FormulacionController extends SimpleController {

	
	public $twig;

	function __construct($twig) {
		$this->twig = $twig;
		parent::__construct('Formulacion','FormulacionController',$twig);
				
	}

		

}

?>