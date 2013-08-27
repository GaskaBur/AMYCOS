<?php
/*
* AMYCOS ERP
*
* @author: Sergio Gil Pérez
* @Company: Noises of Hill
* @year: 2013
*
*/

class Archivo extends Model {

	#int - id_archivo
	public $id_archivo;

	#String - nombre
	public $nombre;

	#String - extensión
	public $extension;

	#String - Cabecera que contiene el tipo de archivo
	public $header;

	#Date - Fecha de alta
	public $fecha_alta;

	#int - id usuario propietario
	public $id_usuario;

	#String - descripcion
	public $descripcion;

	#int categoria Archivo
	public $id_categoria_archivo;

	#tabla asociada a la calse
	static $tabla = 'archivos';

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
		'table' => 'archivos',
		'primary' => 'id_archivo',
		'fields' => array(
			'nombre' => array('type' => TYPE_STRING, 'value' => ''),
			'extension' => array('type' => TYPE_STRING, 'value' => ''),
			'header' => array('type' => TYPE_STRING, 'value' => ''),
			'fecha_alta' => array('type' => TYPE_DATE, 'value' => ''),
			'id_usuario' => array('type' => TYPE_STRING, 
				'value' => '',
				'relation' => 'usuario',
				'relationKey' => 'nombre',
				'where' => null),
			'descripcion' => array('type' => TYPE_STRING, 'value' => ''),
			'id_categoria_archivo' => array('type' => TYPE_INT, 'value' => 0),
		),
	);
	
	function __construct($_id = null) {
		parent::__construct($_id);		
	}

	/*
	Devuelve un array con todos los archivos .
	*/
	public static function selectAll($tabla = null,$where = null, $order = null)
	{
		return parent::selectAll(Archivo::$tabla);
	}
	

	

}
?>
