<?php

class CategoriasUsuarioController extends SimpleController {

	
	public $twig;

	function __construct($twig) {
		$this->twig = $twig;
		parent::__construct('Categoria_Usuario','CategoriasUsuarioController',$twig);
				
	}

		

}

?>