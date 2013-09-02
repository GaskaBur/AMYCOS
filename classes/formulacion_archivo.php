<?php

class Formulacion_Archivo extends DB {

	#Usuario
	public $formulacion;

	#Forma Contacto
	public $archivo;
	
	function __construct($_id_formulacion, $_id_archivo) {
		$this->formulacion = new Formulacion($_id_formulacion);
		$this->archivo = new Archivo($_id_archivo);
						
	}

	public function save(){
		
		if ($this->formulacion->id_formulacion != 0 && $this->archivo->id_archivo != 0)
			$this->execute(
				sprintf("INSERT INTO formulaciones_archivos VALUES (%d,%d)",(int)$this->formulacion->id_formulacion,(int)$this->archivo->id_archivo)
			);
	}

	
	/*
	Devuelve un Array con las formas de contacto preferidas de un usuario
	*/
	public static function getArchivos($id_formulacion){
		$sql = sprintf("SELECT ar.id_naturaleza, ar.descripcion 
			FROM formulaciones_archivos as fa 
			INNER JOIN archivos as ar ON ar.id_archivo = fa.id_archivo  
			WHERE id_formulacion = %d",$id_formulacion);
		return DB::getInstance()->executeQ($sql);
	}


}
?>