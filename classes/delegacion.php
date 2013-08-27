<?php
/*
* AMYCOS ERP
*
* @author: Sergio Gil Pérez
* @Company: Noises of Hill
* @year: 2013
*
*/

#Definición de la clase Delegación
#las delegaciones pueden ser: Burgos, Vitoria, Bilbao ...

class Delegacion extends Model {

	#int - id única de cada delegación
	public $id_delegacion;

	#String - nombre o descripción de la delegación
	public $descripcion;

	#Tabla asociada la Clase
	static $tabla = 'delegaciones';

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
		'table' => 'delegaciones',
		'primary' => 'id_delegacion',
		'fields' => array(
			'descripcion' => array('type' => TYPE_STRING, 'value' => ''),
		),
	);
	
	#Constructor
	function __construct($_id = null) {
		parent::__construct($_id);
				
	}

	/*
	Devuelve el id único de la delegación dada su descripción:
	$descripcion -> id 
	*/
	public function getIdByDescription($descripcion,$s=null){
		return parent::getIdByDescription($descripcion);
	}

	/*
	Devuele un array con todas las delegaciones
	*/
	public static function selectAll($tabla = null,$where = null, $order = null)
	{
		return parent::selectAll(Delegacion::$tabla);
	}

	

}
?>