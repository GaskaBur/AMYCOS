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

class Categoria_Archivo extends Model {

	#int - id_única
	public $id_categoria_archivo;

	#String - nombre de la categoría
	public $descripcion;

	#int - id categoría padre
	//public $id_categoria_archivo_padre;

	#tabla asociada a la calse
	static $tabla = 'categorias_archivos';
	
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
		'table' => 'categorias_archivos',
		'primary' => 'id_categoria_archivo',
		'fields' => array(
			'descripcion' => array('type' => TYPE_STRING, 'value' => ''),
			/*
			'id_categoria_archivo_padre' => array(
				'type' => TYPE_INT, 
				'value' => '', 
				'relation' => 'categoria_archivo', 
				'relationKey' => 'descripcion',
				'where' => null),*/
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
	Devuelve un array con todas las Categorias .
	*/
	public static function selectAll($tabla = null,$where = null, $order = null)
	{
		return parent::selectAll(Categoria_Archivo::$tabla);
	}
	
}
?>