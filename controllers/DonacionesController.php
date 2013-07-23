<?php

class DonacionesController extends SimpleController {

	
	public $twig;

	function __construct($twig) {
		$this->twig = $twig;
		parent::__construct('Donacion','DonacionesController',$twig);
				
	}

		

}

?>