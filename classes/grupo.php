<?php
/*
* AMYCOS ERP
*
* @author: Sergio Gil Pérez
* @Company: Noises of Hill
* @year: 2013
*
*/

#Definición de la clase Grupos de voluntarios
#los grupos de voluntarios pueden ser: Loteria, prácticas, etc...

class Grupo extends Model {

	#int - id unica del grupo
	public $id_grupo;

	#String - nombre o descripción del grupo de voluntarios
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
		'table' => 'grupos',
		'primary' => 'id_grupo',
		'fields' => array(
			'descripcion' => array('type' => TYPE_STRING, 'value' => ''),
		),
	);
	
	function __construct($_id = null) {
		parent::__construct($_id);
				
	}

	/*
	Devuelve el id único del grupo dada su descripción:
	$descripcion -> id 
	*/
	public function getIdByDescription($descripcion,$s=null){
		return parent::getIdByDescription($descripcion);
	}	

}
?>