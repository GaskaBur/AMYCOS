<?php

class GruposController extends SimpleController {

	
	public $twig;

	function __construct($twig) {
		$this->twig = $twig;
		parent::__construct('Grupo','GruposController',$twig);
				
	}

		

}

?>