<?php

class EstadoFormulacionController extends SimpleController {
	
	public $twig;

	function __construct($twig) {
		$this->twig = $twig;
		parent::__construct('Estado_Formulacion','EstadoFormulacionController',$twig);
				
	}		

}

?>
