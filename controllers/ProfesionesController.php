<?php

class ProfesionesController extends SimpleController {

	
	public $twig;

	function __construct($_twig) {
		$this->twig = $_twig;
		parent::__construct('Profesion','ProfesionesController',$_twig);
				
	}

		

}

?>