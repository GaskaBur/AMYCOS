<?php
/*
* AMYCOS ERP
*
* @author: Sergio Gil Pérez
* @Company: Noises of Hill
* @year: 2013
*
*/

#Definición de la clase Estudio
#los estudios pueden ser: Formación profesional, Universitarios, etc..

class Estudio extends Model {

	#int - id unica para cada tipo de estudio
	public $id_estudio;

	#String - nombre o descripción del tipo de estudio
	public $descripcion;

	#tabla asociada a la clase
	static $tabla = 'estudios';

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
		'table' => 'estudios',
		'primary' => 'id_estudio',
		'fields' => array(
			'descripcion' => array('type' => TYPE_STRING, 'value' => ''),
		),
	);
	
	function __construct($_id = null) {
		parent::__construct($_id);
				
	}

	/*
	Devuelve el id único de Estudio dada su descripción:
	$descripcion -> id 
	*/
	public function getIdByDescription($descripcion,$s=null){
		return parent::getIdByDescription($descripcion);
	}

	/*
	Devuele un array con todas los tipos de esudio
	*/
	public static function selectAll($tabla = null)
	{
		return parent::selectAll(Estudio::$tabla);
	}

}
?>