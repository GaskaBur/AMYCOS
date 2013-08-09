<?php

class Voluntarios_Naturalezas extends DB {

	#Usuario
	public $voluntario;

	#Forma Contacto
	public $naturaleza;
	
	function __construct($_id_voluntario, $_id_naturaleza) {
		$this->voluntario = new Voluntario($_id_voluntario);
		$this->naturaleza = new Naturaleza($_id_naturaleza);
						
	}

	public function save(){
		
		if ($this->voluntario->id_voluntario != 0 && $this->naturaleza->id_naturaleza != 0)
			$this->execute(
				sprintf("INSERT INTO voluntarios_naturalezas VALUES (%d,%d)",(int)$this->voluntario->id_voluntario,(int)$this->naturaleza->id_naturaleza)
			);
	}

	
	/*
	Devuelve un Array con las formas de contacto preferidas de un usuario
	*/
	public static function getNaturalezas($id_voluntario){
		$sql = sprintf("SELECT fc.id_naturaleza, fc.descripcion 
			FROM voluntarios_naturalezas as ufc 
			INNER JOIN naturalezas as fc ON ufc.id_naturaleza = fc.id_naturaleza  
			WHERE id_voluntario = %d",$id_voluntario);
		return DB::getInstance()->executeQ($sql);
	}


}
?>