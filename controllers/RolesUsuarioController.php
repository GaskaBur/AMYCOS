<?php

class RolController extends SimpleController {

	
	public $twig;

	function __construct($twig) {
		$this->twig = $twig;
		parent::__construct('Rol','RolController',$twig);
				
	}

		

}

?>