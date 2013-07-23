<?php

class DB {
	
	#Host de la Base de datos
	private $db_host;
	
	#Nombre de la Base de Datos
	private $db_table;
	
	#Usuario de la Base de datos
	private $db_user;
	
	#Password de la Base de datos
	private $db_pass;

	protected $con;
	
	# constructor de la clase
	function __construct() {
		$this->db_host = _DB_HOST_;
		$this->db_name = _DB_TABLE_;
		$this->db_table = _DB_USER_;
		$this->db_pass = _DB_PASS_;
	}
	
	/*
	Abre la conexión con la base de datos
	*/
	protected function open_connection() {
		// Creando conexión
		$this->con=new mysqli(_DB_HOST_,_DB_USER_,_DB_PASS_,_DB_TABLE_);

		// Check connection
		if ($this->con->connect_errno)
		{
		 	echo "Failed to connect to MySQL: " . mysqli_connect_error();
		 	Alert::show('No se ha podido conectar, motivo: '.mysqli_connect_error());
		 	die;
		}
		else{

		}		
			
	}

	/*
	Cierra la conexión con la Base de datos.
	*/
	protected function close_connection() {
		mysqli_close($this->con);
	}

	

	

	public function executeQ($query)
	{
		$registro = array();
		$conexion =new mysqli(_DB_HOST_,_DB_USER_,_DB_PASS_,_DB_TABLE_);
		if ($conexion->connect_errno)
		{
		 	echo "Failed to connect to MySQL: " . mysqli_connect_error();
		 	Alert::show('No se ha podido conectar, motivo: '.mysqli_connect_error());
		 	die;
		}		
		
		$result = $conexion->query($query);
		
		while ($fila = mysqli_fetch_assoc($result)) {
			$registro[] = $fila; 			
		}		

		mysqli_close($conexion);
		return $registro;
	}


	public function execute($query)
	{
		$registro = array();
		$conexion =new mysqli(_DB_HOST_,_DB_USER_,_DB_PASS_,_DB_TABLE_);
		if ($conexion->connect_errno)
		{
		 	echo "Failed to connect to MySQL: " . mysqli_connect_error();
		 	Alert::show('No se ha podido conectar, motivo: '.mysqli_connect_error());
		 	die;
		}		
		$result = $conexion->query($query);
		mysqli_close($conexion);
		return $result;
	}


	public static function getInstance(){
		$instancia = new DB();
		return $instancia;
	}

	

	

	
	
}

?>
