<?php

class TipoAltaController extends SimpleController {

	
	public $twig;

	function __construct($_twig) {
		$this->twig = $_twig;
		parent::__construct('Tipo_Alta','TipoAltaController',$_twig);
				
	}

		

}

?>