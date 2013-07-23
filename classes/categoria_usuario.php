<?php
/*
* AMYCOS ERP
*
* @author: Sergio Gil Pérez
* @Company: Noises of Hill
* @year: 2013
*
*/

#Definición de la clase Categoria_usuario
#las Categorias usuario pueden ser: adulto, menor, mayor, ....

class Categoria_Usuario extends Model {

	#int - id_usuario asciado
	public $id_categoria_usuario;

	#String - nombre de la categoría
	public $descripcion;

	#tabla asociada a la calse
	static $tabla = 'categorias_usuario';
	
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
		'table' => 'categorias_usuario',
		'primary' => 'id_categoria_usuario',
		'fields' => array(
			'descripcion' => array('type' => TYPE_STRING, 'value' => ''),
		),
	);
	
	function __construct($_id = null) {
		parent::__construct($_id);
				
	}

	/*
	Devuelve el id único de la Categoría dada su descripción:
	$descripcion -> descripción 
	*/
	public function getIdByDescription($descripcion,$s=null){
		return parent::getIdByDescription($descripcion);
	}

	/*
	Devuelve un array con todas las Categorias de usuario.
	*/
	public static function selectAll($tabla = null)
	{
		return parent::selectAll(Categoria_Usuario::$tabla);
	}
	
}
?>