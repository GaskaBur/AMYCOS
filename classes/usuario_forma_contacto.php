<?php

class Usuario_Formas_Contacto extends DB {

	#Usuario
	public $usuario;

	#Forma Contacto
	public $forma_contacto;
	
	function __construct($_id_usuario, $_id_forma_contacto) {
		$this->usuario = new Usuario($_id_usuario);
		$this->forma_contacto = new Forma_Contacto($_id_forma_contacto);
						
	}

	public function save(){
		
		if ($this->usuario->id_usuario != 0 && $this->forma_contacto->id_forma_contacto != 0)
			$this->execute(
				sprintf("INSERT INTO usuario_formas_contacto VALUES (%d,%d)",(int)$this->usuario->id_usuario,(int)$this->forma_contacto->id_forma_contacto)
			);
	}

	
	/*
	Devuelve un Array con las formas de contacto preferidas de un usuario
	*/
	public static function getFormasContacto($id_usuario){
		$sql = sprintf("SELECT fc.id_forma_contacto, fc.descripcion 
			FROM usuario_formas_contacto as ufc 
			INNER JOIN formas_contacto as fc ON ufc.id_forma_contacto = fc.id_forma_contacto  
			WHERE id_usuario = %d",$id_usuario);
		return DB::getInstance()->executeQ($sql);
	}


}
?>