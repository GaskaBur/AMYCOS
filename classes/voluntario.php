<?php
/*
* AMYCOS ERP
*
* @author: Sergio Gil Pérez
* @Company: Noises of Hill
* @year: 2013
*

#Definición de la clase Voluntario
*/

class Voluntario extends Model {

	#int - id_voluntario -> id única por cada voluntario
	public $id_voluntario;

	#int - id_usuario asociada a esta cuenta de voluntario
	public $id_usuario;

	#int - id de la procedencia del voluntario
	public $id_procedencia;

	#int- id_clase, indica la clase de voluntario
	public $id_clase;

	#String - alias o nick que usará en voluntario en el sistema
	public $alias;

	#string - MD5 - Contraseña del usuario dentro el sistema
	public $pass;

	#int - año old -> indica el último año en el que participo como voluntario en el antiguo sistema
	public $anio_old;

	#String - Preferencias del usuario
	public $preferencias;

	#String - Disponibilidad
	public $disponibilidad;	

	#Boolena - indica si el usuario esta activo o no como voluntario
	public $activo;

	#int - id del usuario mentor de este voluntario
	public $id_usuario_mentor;

	#String - concreta la procedencia exacta del voluntario.
	public $info_procedencia;

	static $tabla = 'voluntarios';

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
		'table' => 'voluntarios',
		'primary' => 'id_voluntario',
		'fields' => array(
			'id_usuario' => array('type' => TYPE_INT, 'isRequired' => true,'relation' => 'Usuario', 'relationKey' => 'nombre', 'where' => 'id_usuario NOT IN(SELECT id_usuario FROM voluntarios)'),
			'id_procedencia' => array('type' => TYPE_INT, 'relation' => 'Procedencia', 'relationKey' => 'descripcion', 'where' => null),
			'alias' => array('type' => TYPE_STRING),
			'pass' => array('type' => TYPE_MD5),
			'id_clase' => array('type' => TYPE_INT, 'isRequired' => true,'relation' => 'Clase', 'relationKey' => 'descripcion', 'where' => null),
			'anio_old' => array('type' => TYPE_STRING),
			'preferencias' => array('type' => TYPE_STRING),
			'disponibilidad' => array('type' => TYPE_STRING),
			'activo' => array('type' => TYPE_BOOL),
			'id_usuario_mentor' => array('type' => TYPE_INT, 'relation' => 'Usuario', 'relationKey' => 'nombre', 'where' => null),
			'info_procedencia' => array('type' => TYPE_STRING),
			
		),
	);

	
	function __construct($_id = null) {
		parent::__construct($_id);		
	}

	
	

}
?>
