<?php
/*
* AMYCOS ERP
*
* @author: Sergio Gil Pérez
* @Company: Noises of Hill
* @year: 2013
*
*/

#Definición de la clase Forma_contacto
#las formas de contacto pueden ser: telefono, sms, twitter, etc...

class Forma_Contacto extends Model {

	#int - id única de cada forma de contacto
	public $id_forma_contacto;

	#String - nombre o descripción de la forma de contacto
	public $descripcion;

	#Tabla asociada a la Clase
	static $tabla = 'formas_contacto';

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
		'table' => 'formas_contacto',
		'primary' => 'id_forma_contacto',
		'fields' => array(
			'descripcion' => array('type' => TYPE_STRING, 'value' => ''),
		),
	);
	
	function __construct($_id = null) {
		parent::__construct($_id);
				
	}

	/*
	Devuelve el id único de la Forma de contacto dada su descripción:
	$descripcion -> id 
	*/
	public function getIdByDescription($descripcion,$s=null){
		return parent::getIdByDescription($descripcion);
	}

	/*
	Devuele un array con todas las formas de contacto
	*/
	public static function selectAll($tabla = null)
	{
		return parent::selectAll(Forma_Contacto::$tabla);
	}
	

}
?>