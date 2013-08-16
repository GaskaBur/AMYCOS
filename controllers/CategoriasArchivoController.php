<?php

class CategoriasArchivosController extends SimpleController {

	
	public $twig;

	function __construct($twig) {
		$this->twig = $twig;
		parent::__construct('Categoria_Archivo','CategoriasArchivosController',$twig);
				
	}

	public static function getAllCategories($parent = 0){
		$sql = sprintf("SELECT * FROM categorias_archivos WHERE id_categoria_archivo_padre = %d",$parent);
		$result =  DB::getInstance()->executeQ($sql);
		$exit = array();
		foreach ($result as $key => $value) {
			echo $value['id_categoria_archivo'];
			$exit[] = $value;
			$exit[] = CategoriasArchivosController::getAllCategories($value['id_categoria_archivo']);
		}
		print_r($exit);
		return $exit;
	}

		

}

?>