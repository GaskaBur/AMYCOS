<?php
/*
* AMYCOS ERP
*
* @author: Sergio Gil Pérez
* @Company: Noises of Hill
* @year: 2013
*
*/

#Definición de la clase donaciones
#Contiene las donaciones que un usuario ha realizado a un proyecto

class Donacion extends Model {

	#int - id única de cada donación
	public $id_donacíon;

	#int - id del usuario que ha realizado la donación
	public $id_usuario;

	#int - id el proyecto al que está destinada la donación
	public $id_proyecto;

	#date - fecha-In: fecha de inicio del periodo de donación
	public $fecha_in;

	#date - fecha-Out: fecha final del periodo de donación, si es null la donación sigue activa
	public $fecha_out;

	#float - cantidad que se entrega en la donación
	public $cantidad;	

	#String- Periocidad de la donación
	public $periocidad;

	#String - Númeo de cuenta donde se cargará la donación
	public $numero_cuenta;

	#String - Observaciones
	public $observaciones;

	static $tabla = 'donaciones';

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
		'table' => 'donaciones',
		'primary' => 'id_donacion',
		'fields' => array(
			'id_usuario' => array('type' => TYPE_INT, 'value' => 0, 'isRequired' => true,'relation' => 'Usuario','relationKey' => 'nombre','where' => null),
			'id_proyecto' => array('type' => TYPE_INT, 'value' => 0, 'isRequired' => true,'relation' => 'Proyecto','relationKey' => 'descripcion','where' => null),
			'fecha_in' => array('type' => TYPE_DATE, 'isRequired' => true),
			'fecha_out' => array('type' => TYPE_DATE),
			'cantidad' => array('type' => TYPE_FLOAT, 'value' => ''),
			'periocidad' => array('type' => TYPE_STRING),
			'numero_cuenta' => array('type' => TYPE_STRING),
			'observaciones' => array('type' => TYPE_STRING),
		),
	);
	
	function __construct($_id = null) {
		parent::__construct($_id);
				
	}

	
	
	

	
}
?>
