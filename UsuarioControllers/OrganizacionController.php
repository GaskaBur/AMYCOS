<?php

class OrganizacionController extends UsuarioController {
	
	public $twig;

	function __construct($_twig) {
		$this->twig = $_twig;
		parent::__construct('Usuario','OrganizacionController',$_twig);
				
	}	
	
	

}

?>