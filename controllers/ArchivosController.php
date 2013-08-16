<?php

class ArchivosController extends SimpleController {

	
	public $twig;

	function __construct($twig) {
		$this->twig = $twig;
		parent::__construct('Archivo','ArchivosController',$twig);
				
	}

		

}

?>