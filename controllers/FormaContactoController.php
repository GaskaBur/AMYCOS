<?php

class FormaContactoController extends SimpleController {

	
	public $twig;

	function __construct($_twig) {
		$this->twig = $_twig;
		parent::__construct('Forma_Contacto','FormaContactoController',$_twig);
				
	}

		

}

?>