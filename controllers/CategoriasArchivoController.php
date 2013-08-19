<?php

class CategoriasArchivosController extends SimpleController {

	
	public $twig;

	function __construct($twig) {
		$this->twig = $twig;
		parent::__construct('Categoria_Archivo','CategoriasArchivosController',$twig);
				
	}

	public static function getAllCategories($parent = 0){
		$sql = sprintf("SELECT * FROM categorias_archivos");
		$result =  DB::getInstance()->executeQ($sql);
		return $result;
	}

		

}

?>