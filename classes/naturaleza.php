<?php

class Naturaleza extends Model {

	#int - id_usuario
	public $id_naturaleza;

	#String - nombre
	public $descripcion;

	#Tabla asociada a la Clase
	static $tabla = 'naturalezas';

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
		'table' => 'naturalezas',
		'primary' => 'id_naturaleza',
		'fields' => array(
			'descripcion' => array('type' => TYPE_STRING, 'value' => ''),
		),
	);
	
	function __construct($_id = null) {
		parent::__construct($_id);
				
	}

	/*
	Devuelve el id único de Estudio dada su descripción:
	$descripcion -> descripción 
	*/
	public function getIdByDescription($descripcion,$s=null){
		return parent::getIdByDescription($descripcion);
	}

	/*
	Devuele un array con todas las procedencias
	*/
	public static function selectAll($tabla = null)
	{
		return parent::selectAll(Naturaleza::$tabla);
	}

	

}
?>