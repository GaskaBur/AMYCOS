<?php

class DelegacionesController extends SimpleController {

	
	public $twig;

	function __construct($twig) {
		$this->twig = $twig;
		parent::__construct('Delegacion','DelegacionesController',$twig);
				
	}

		

}

?>