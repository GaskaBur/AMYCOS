<?php
/*
* AMYCOS ERP
*
* @author: Sergio Gil Pérez
* @Company: Noises of Hill
* @year: 2013
*
*/

#Definición de la clase Dirección
#Referido a las direcciones que puede tener un usuario

class Direccion extends Model {

	#int - id única de cada dirección
	public $id_direccion;

	#int - id del usuario propietario de la dirección
	public $id_usuario;

	#String - nombre o descripción de la dirección
	public $alias;

	#String - Campo de texto principal donde especificar el domicilio
	public $direccion1;

	#String - Información ampliada para el domicilio principal
	public $direccion2;

	#String - Código Postal
	public $cp;

	#String - Localidad
	public $localidad;

	#String - Provincia
	public $provincia;

	#String - Pais
	public $pais;

	#int - Orden en el que visualizará esta dirección
	public $orden;



	#Tabla asociada la Clase
	static $tabla = 'direcciones';

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
		'table' => 'direcciones',
		'primary' => 'id_direccion',
		'fields' => array(
			'id_usuario' => array(
				'type' => TYPE_INT, 
				'isRequired' => true, 
				'relation' => 'Usuario', 
				'relationKey' => 'nombre', 
				'where' => null),
			'alias' => array(
				'type' => TYPE_STRING),
			'direccion1' => array(
				'type' => TYPE_STRING),
			'direccion2' => array(
				'type' => TYPE_STRING),
			'cp' => array(
				'type' => TYPE_STRING),
			'localidad' => array(
				'type' => TYPE_STRING),
			'provincia' => array(
				'type' => TYPE_STRING),
			'pais' => array(
				'type' => TYPE_STRING),
			'orden' => array(
				'type' => TYPE_INT),
		),
	);
	
	#Constructor
	function __construct($_id = null) {
		parent::__construct($_id);
				
	}


	/*
	Devuele un array con todas las direcciones
	*/
	public static function selectAll($tabla = null)
	{
		return parent::selectAll(Delegacion::$tabla);
	}

	/*
	Devuelve un array con todas las direcciones de un usuario
	parametros:
	- $id - id del usuario
	- $orden orden en el que se filtrará la tabla, puede ser null
	return array();	
	*/
	public static function getDireccionesId($id,$order = null)
	{
		if ($order == null)
			return DB::getInstance()->executeQ("SELECT * FROM direcciones WHERE id_usuario = ".$id);
		else
			return DB::getInstance()->executeQ("SELECT * FROM direcciones WHERE id_usuario = ".$id.' ORDER BY '.$order);
	}
	

}
?>