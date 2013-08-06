<?php
abstract class Model extends DB {

	protected $fields;

	function __construct($_id=null) {
		parent::__construct(); //Carga la base de datos.
		

		if ($_id != null)
		{
			$model = $this->load($_id,$this->definition);
			if (count($model) != 0)
			{
				$primary = $this->definition['primary'];
				$this->$primary = $_id;
				foreach ($this->definition['fields'] as $key => $value) { 
					$this->$key = $model[$key];
				}
			}
			else
			{
				//No existe modelo
			}			
		}		
	}	

	/*
	Carga en base a la id recibida en el constructor
	*/
	private function load($id) {
		$query = sprintf("SELECT * FROM %s", addslashes($this->definition['table']) );
		$query .= sprintf(" WHERE %s = %d", addslashes($this->definition['primary']), (int)$id);
		$this->open_connection();
		$result = $this->con->query($query);
		$this->close_connection();
		return mysqli_fetch_array($result);			
	}	

	
	/*
	Añade un nuevo registro al modelo correspondiente con los datos en memoria
	*/
	public function add() {
		foreach ($this->definition['fields'] as $key => $value) { 
			$this->definition['fields'][$key]['value'] = $this->$key;
		}
		$sql = sprintf("INSERT INTO %s VALUES (null,", addslashes($this->definition['table']));
		$loop = 1;
		foreach ($this->definition['fields'] as $field) {
			switch ($field['type']) {
				case TYPE_STRING:
					$sql .= sprintf("'%s'", addslashes(utf8_decode($field['value'])));
					break;
				case TYPE_INT:
					$sql .= (int)$field['value'];
					break;	
				case TYPE_FLOAT:
					$sql .= (int)$field['value'];
					break;		
				case TYPE_BOOL:		
					$sql .= (int)$field['value'];
					break;		
				case TYPE_DATE:		
					$sql .= sprintf("'%s'", addslashes(utf8_decode($field['value'])));
					break;		
				case TYPE_MD5:		
					$sql .= sprintf("'%s'", addslashes(utf8_decode(md5($field['value']))));
					break;	
			}				
			if ($loop != count($this->definition['fields']))
				$sql .= ",";
			$loop++;
		}
		$sql .= ")";

		$this->open_connection();
		if ($this->con->query($sql))
		{
			$sql = sprintf("SELECT %s FROM %s ORDER BY %s DESC", $this->definition['primary'], $this->definition['table'],$this->definition['primary']);
			$id = mysqli_fetch_array($this->con->query($sql));	
			$this->close_connection();
			return $id[0];
		}
		else
		{
			$this->close_connection();
			return false;
		}		
	}

	/*
	obtiene todos los registros del modelo
	*/
	public function getAll($where = null, $order = null)
	{
		if ($where == null)
			$query = sprintf("SELECT %s FROM %s", '*', addslashes($this->definition['table']) );
		else
			$query = sprintf("SELECT %s FROM %s WHERE %s", '*', addslashes($this->definition['table']),$where );

		if ($order != null)
			$query .= " ORDER BY ".$order;
		
		parent::open_connection();
		$result = $this->con->query($query);	
		$registro = array();	
		while ($fila = mysqli_fetch_assoc($result)) {
			$registro[] = $fila; 			
		}		
		$this->close_connection();		
		
		return $registro;
	}

	public static function selectAll($table)
	{
		$query = sprintf("SELECT %s FROM %s", '*', addslashes($table) );
		return DB::getInstance()->executeQ($query);
	}

	/*
	Este metodo es unicamente para las tablas auxiliares que solo tienen:
	 - id_primary
	 - descripcion
	*/
	public function getIdByDescription($descripcion)
	{
		$query = sprintf("SELECT %s FROM %s", addslashes($this->definition['primary']), addslashes($this->definition['table']) );
		$query .= sprintf(" WHERE %s = '%.s'", 'descripcion', $descripcion);
		$this->open_connection();
		$result = $this->con->query($query);
		$this->close_connection();
		return( mysqli_fetch_assoc($result));
	} 


	public function delete($id)
	{
		$query = sprintf("DELETE FROM %s WHERE %s = %d", addslashes($this->definition['table']),addslashes($this->definition['primary']), (int)$id );
		$this->open_connection();
		$result = $this->con->query($query);
		$this->close_connection();
	}

	public function update($_id)
	{
		$query = sprintf("UPDATE %s SET ", addslashes($this->definition['table']) );
		foreach ($this->definition['fields'] as $key => $value)
		{

			switch ($value['type']) {
				case TYPE_STRING:
					$query .= $key."='".$this->$key."',";
					break;
				case TYPE_INT:
					$query .= $key."=".$this->$key.",";
					break;
				case TYPE_FLOAT:
					$query .= $key."=".$this->$key.",";
					break;	
				case TYPE_BOOL:		
					$query .= $key."=".$this->$key.",";
					break;		
				case TYPE_DATE:		
					$query .= $key."='".$this->$key."',";
					break;		
				case TYPE_MD5:		
					$query .= $key."='".md5($this->$key)."',";
					break;	
			}				
			/*
			if ($value['type'] == TYPE_STRING)
				$query .= $key."='".$this->$key."',";
			else
				$query .= $key."=".$this->$key.",";
			*/
		}
		$query = substr($query, 0, -1);
		$query .= sprintf(" WHERE %s = %d", addslashes($this->definition['primary']), (int)$_id );
		$this->open_connection();
		$result = $this->con->query($query);
		$this->close_connection();

	}

	/*
	Genera un formulario en base al fieldset de la calse
	*/
	public function genForm($_controller, $_action, $_class)
	{
		
		//Si llega id se envía por GET la id de trabajo
		if (isset($_GET['id']))
		{
			$output = '<form action="?controller='.$_controller.'&action='.$_action.'&id='.$_GET['id'].'" method="post">';
			$clase = new $_class($_GET['id']);
			
		}
		else
			$output = '<form action="?controller='.$_controller.'&action='.$_action.'" method="post">';
		
		$output .= '<fieldset>';

		//parseando el fieldSet definition
		foreach ($this->definition['fields'] as $key => $value) { 
			
			$output .= '<label for="'.$key.'">'.$key.'</label>';

			if (!isset($value['relation']))
			{
				if ($value['type'] == TYPE_BOOL)
				{
					$output .= '<select $id="'.$key.'" name="'.$key.'">';
					if (isset($clase))
					{
						if($clase->$key == 0)
						{
							$output .= '<option value="0" selected>0</option>';
							$output .= '<option value="1">1</option>';
						}
						else
						{
							$output .= '<option value="0">0</option>';
							$output .= '<option value="1" selected>1</option>';
						}
					}
					else
					{
						$output .= '<option value="0">0</option>';
						$output .= '<option value="1" selected>1</option>';
					}
					$output .= '</select>';
				}
				else if ($value['type'] == TYPE_DATE) {
					$output .= '<script>$(function() {$( "#'.$key.'" ).datepicker({ dateFormat: "yy-mm-dd" });});</script>';
					if (isset($clase))
						$output .= '<input type="input" id="'.$key.'" name="'.$key.'" value="'.$clase->$key.'"/>';
					else
						$output .= '<input type="input" id="'.$key.'" name="'.$key.'" />';
						
				}

				else if (isset($clase))
					$output .= '<input type="input" id="'.$key.'" name="'.$key.'" value="'.$clase->$key.'"/>';
				else
					$output .= '<input type="input" id="'.$key.'" name="'.$key.'" />';
			}
			else
			{
				if (isset($clase))
					$anterior =  $clase->$key;
				else
					$anterior = null;
		
				$classRelation = new $value['relation']();
				$output .= '<select $id="'.$key.'" name="'.$key.'">';
				if (!isset($value['isRequired']))
					$output .= '<option value="0"></option>';
				
				foreach ($classRelation->getAll($value['where']) as $key => $value2) {
					$id = 'id_'.strtolower($value['relation']);
					$output .= '<option value="'.$value2[$id].'"';
					if ($value2[$id] == $anterior)
						$output .= ' selected';
					$output .='>'.$value2[$value['relationKey']].'</option>';						
				}
				
				$output .= '</select>';
			}
		}
		$output .= '<input type="submit" value="Enviar"/>';
		$output .= '</fieldset>';
		$output .= '</form>';
		return $output;
	}

}

?>