<?php

class Rol extends Model {

	#int - id_usuario
	public $id_procedencia;

	#String - nombre
	public $descripcion;

	#int - id_rol_padre
	public $id_rol_padre;

	static $tabla = 'roles';

	/*
	Definición de datos:
	table = tabla principal asociada a la clase
	primary = nombre del campoPrimary Key de la tabla principal
	fields:
	------------------------------------------------
	nombre del campo:
	------------------------------------------------
		* type= [TYPE_INT|TYPE_STRING|TYPE_BOOL|TYPE_MD5|TYPE_DATA ...]
		* value = valor por defecto
		* isRequired = true si el campo es obligatorio en la tabla de la base de datos
		* relation = si el campo está asociado a alguna tabla de la base de datos
		* relationKey = campo que se mostrará en la asociacón
		* where = limitación del where al realizar la consulta para conseguir los datos de la relación.
	*/
	public $definition = array(
		'table' => 'roles',
		'primary' => 'id_rol',
		'fields' => array(
			'descripcion' => array('type' => TYPE_STRING, 'value' => '', 'isRequired' => true),
			'id_rol_padre' => array('type' => TYPE_INT, 'value' => 0, 'relation' => 'Rol', 'relationKey' => 'descripcion','where' => null),
		),
	);
	
	function __construct($_id = null) {
		parent::__construct($_id);
				
	}

	/*
	Devuelve el id único de la Procedencia dada su descripción:
	$descripcion -> descripción 
	*/
	public function getIdByDescription($descripcion,$s=null){
		return parent::getIdByDescription($descripcion);
	}

	public static function selectAll($tabla = null)
	{
		return parent::selectAll(Rol::$tabla);
	}
	

}
?>
