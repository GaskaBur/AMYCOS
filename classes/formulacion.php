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

class Formulacion extends Model {

	#int - id unica para cada tipo de estudio
	public $id_formulacion;

	#String - nombre o descripción del tipo de estudio
	public $descripcion;

	#Date - fecha de alta de la formulación
	public $fecha_formulacion;

	#Date - feca límite de presentación de la resolución
	public $fecha_presentacion;

	#Date - Fecha de resolución
	public $fecha_resolucion;

	#int - id del estado en el que se encuentra la formulacion
	public $id_estado_formulacion;

	#int - id del usuario que ha creado la formulacion
	public $id_usuario;

	#text - observaciones
	public $observaciones;

	#array - archivos
	public $archivos;

	#tabla asociada a la clase
	static $tabla = 'formulaciones';

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
		* session = tomá su valor de la variable de session referenciada.
		* hidden = indica que el valor será hidden en el formulario
	*/
	public $definition = array(
		'table' => 'formulaciones',
		'primary' => 'id_formulacion',
		'fields' => array(
			'descripcion' => array('type' => TYPE_STRING, 'value' => '', 'isRequired' => true),
			'fecha_formulacion' => array('type' => TYPE_DATE, 'value' => 'now', 'hidden' => true),
			'fecha_presentacion' => array('type' => TYPE_DATE),
			'fecha_resolucion' => array('type' => TYPE_DATE),
			'id_estado_formulacion' => array('type' => TYPE_INT,
				'relation' => 'Estado_Formulacion',
				'relationKey' => 'descripcion'),
			'id_usuario' => array('type' => TYPE_INT,'session' => 'id_usuario'),
			'observaciones' => array('type' => TYPE_AREA),
		),
	);
	
	function __construct($_id = null) {
		parent::__construct($_id);
				
	}

	/*
	Devuelve el id único de la formulación dada su descripción:
	$descripcion -> id 
	*/
	public function getIdByDescription($descripcion,$s=null){
		return parent::getIdByDescription($descripcion);
	}

	/*
	Devuele un array con todas las formulaciones
	*/
	public static function selectAll($tabla = null,$where = null, $order = null)
	{
		return parent::selectAll(Formulacion::$tabla);
	}

}
?>