<?php
/*
* AMYCOS ERP
*
* @author: Sergio Gil Pérez
* @Company: Noises of Hill
* @year: 2013
*
*/

#Definición de la clase Telefono
#Contiene un numero de telefono asociado a un usuario y a una etiqueta

class Mail extends Model {

	#int - id_telefono
	public $id_mail;

	#int - usuario propietario
	public $id_usuario;

	#String - etiqueta asignada al teléfono
	public $etiqueta;

	#String - número de teléfono
	public $mail;	

	#int- orden- Posición en la que aparece el mail
	public $orden;

	static $tabla = 'mails';

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
		'table' => 'mails',
		'primary' => 'id_mail',
		'fields' => array(
			'id_usuario' => array('type' => TYPE_INT, 'value' => 0, 'isRequired' => true, 
				'relation' => 'Usuario', 
				'relationKey' => 'nombre',
				'where' => 'activo = 1'),
			'etiqueta' => array('type' => TYPE_STRING, 'value' => ''),
			'mail' => array('type' => TYPE_STRING, 'value' => ''),
			'orden' => array('type' => TYPE_INT, 'value' => '99'),
		),
	);
	
	function __construct($_id = null) {
		parent::__construct($_id);
				
	}

	/*
	Devuelve el id único de la Procedencia dada su descripción:
	$descripcion -> descripción 
	*/
	public function getIdByDescription($descripcion,$s=null){
		return parent::getIdByDescription($descripcion);
	}

	public static function selectAll($tabla = null)
	{
		return parent::selectAll(Telefono::$tabla);
	}

	/*
	Devuelve un array con los emails de un usuario
	parametros:
	- $id - id del usuario
	- $orden orden en el que se filtrará la tabla, puede ser null
	return array();	
	*/
	public static function getMailsId($id,$order = null)
	{
		if ($order == null)
			return DB::getInstance()->executeQ("SELECT * FROM mails WHERE id_usuario = ".$id);
		else
			return DB::getInstance()->executeQ("SELECT * FROM mails WHERE id_usuario = ".$id.' ORDER BY '.$order);
	}
	

}
?>
