<?php
/*
* AMYCOS ERP
*
* @author: Sergio Gil Pérez
* @Company: Noises of Hill
* @year: 2013
*
*/

#Definición de la clase Clase
#las clases pueden ser: cooperación, sensibilización, etc..

class Clase extends Model {

	#int - id única de la calse
	public $id_clase;

	#String - nombre o descripción de la clase
	public $descripcion;

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
		'table' => 'clases',
		'primary' => 'id_clase',
		'fields' => array(
			'descripcion' => array('type' => TYPE_STRING, 'value' => ''),
		),
	);
	
	#Constructor
	function __construct($_id = null) {
		parent::__construct($_id);
				
	}

	/*
	Devuelve el id único de la clase dada su descripción:
	$descripción -> id 
	*/
	public function getIdByDescription($descripcion,$s=null){
		return parent::getIdByDescription($descripcion);
	}	

}
?>