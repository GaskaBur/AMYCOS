<?php

class VoluntarioController extends SimpleController {
	
	public $twig;

	function __construct($_twig) {
		$this->twig = $_twig;
		parent::__construct('Voluntario','VoluntarioController',$_twig);
				
	}		

}

?>