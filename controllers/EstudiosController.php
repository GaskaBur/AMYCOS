<?php

class EstudiosController extends SimpleController {

	
	public $twig;

	function __construct($twig) {
		$this->twig = $twig;
		parent::__construct('Estudio','EstudiosController',$twig);
				
	}

		

}

?>
