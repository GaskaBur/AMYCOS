<?php

class Usuario extends Model {

	#int - id_usuario
	public $id_usuario;

	#int - Tipo_usuario
	/*
	0 = Persona
	1 = Organización
	*/
	public $tipo_usuario;

	#dateTime - fecha_alta
	public $fecha_alta = null;

	#int - id tipo de alta
	public $id_tipo_alta;

	#String - nombre
	public $nombre;

	#String - nombre corto (Organizaciones)
	public $nombre_corto;

	#int - id categoria del usuario
	public $id_categoria_usuario;

	#int- id rol del usuario
	public $id_rol;

	#int - id delegación del usuario
	public $id_delegacion;

	#string - web
	public $web;

	#String - cif
	public $cif;

	#String - primer apellido
	public $primer_apellido;

	#String - Segundo apellido
	public $segundo_apellido;	

	#String - nacionalidad
	public $nacionalidad;

	#dateTime - Fecha de nacimiento
	public $fecha_nacimiento;

	#Char - sexo
	public $genero;

	#String - tratamiento
	public $tratamiento;

	#String - Teléfono fijo
	public $tfno_fijo;

	#String - prefijo internaciona
	public $pre_internacional;

	#String - Teléfono móvil
	public $tfno_movil;

	#String - mail
	public $mail;

	#String twitter
	public $twitter;

	#String - Mejor horario de consulta
	public $horario_consulta;

	#String - Como nos has conocido
	public $como_conocido;

	#int - Id estudios
	public $id_estudios;

	#int - Id profesion
	public $id_profesion;

	#boolean
	public $suscriptor = 0;

	#boolean
	public $proveedor = 0;

	#boolean
	public $socio_local = 0;

	#boolean
	public $prg_becas_old = 0;

	#date
	public $becas_fecha_in;

	#date
	public $becas_fecha_out;

	#boolean
	public $colaborador_old = 0;

	#boolean
	public $donante_old = 0;

	#String - Número de cuenta
	public $numero_cuenta;

	#boolean 0 = pendiente|1 = aprobado
	public $estado;

	#text
	public $observaciones;

	#boolean
	public $administrador = 0;

	#String - Número de cuenta
	public $pass;

	#int - activo -> indica si el usuario está activado
	public $activo = 1;
	
	#boolean -> activo indica que esta clase se puede filtar en listado y tiene campos para ello.
	public $needFilter = true;

	static $tabla = 'usuario';
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
		* filter = true
	*/
	public $definition = array(
		'table' => 'usuario',
		'primary' => 'id_usuario',
		'fields' => array(
			'tipo_usuario' => array(
				'type' => TYPE_INT, 
				'isRequired' => true),

			'fecha_alta' => array('type' => TYPE_DATE),

			'id_tipo_alta' => array(
				'type' => TYPE_INT, 
				'isRequired' => true,
				'filter' => true,
				'tableFilter' => 'tipos_alta',
				'fieldFilter' => 'descripcion'),

			'nombre' => array('type' => TYPE_STRING, 'isRequired' => true, 'filter' => true),

			'nombre_corto' => array('type' => TYPE_STRING),

			'id_categoria_usuario' => array(
				'type' => TYPE_INT, 
				'filter' => true, 
				'tableFilter' => 'categorias_usuario', 
				'fieldFilter' => 'descripcion'),

			'id_rol' => array('type' => TYPE_INT,
				'filter' => true,
				'tableFilter' => 'roles',
				'fieldFilter' => 'descripcion'),

			'id_delegacion' => array('type' => TYPE_INT),
			'web' => array('type' => TYPE_STRING),
			'cif' => array('type' => TYPE_STRING),

			'primer_apellido' => array('type' => TYPE_STRING, 'filter' => true),

			'segundo_apellido' => array('type' => TYPE_STRING, 'filter' => true),

			'nacionalidad' => array('type' => TYPE_STRING, 'filter' => true),

			'fecha_nacimiento' => array('type' => TYPE_DATE, 'filter' => true),

			'genero' => array('type' => TYPE_STRING),
			'tratamiento' => array('type' => TYPE_STRING),
			'tfno_fijo' => array('type' => TYPE_STRING),
			'pre_internacional' => array('type' => TYPE_STRING),
			'tfno_movil' => array('type' => TYPE_STRING),
			'mail' => array('type' => TYPE_STRING),
			'twitter' => array('type' => TYPE_STRING),
			'horario_consulta' => array('type' => TYPE_STRING),
			'como_conocido' => array('type' => TYPE_STRING),
			'id_estudios' => array('type' => TYPE_INT),
			'id_profesion' => array('type' => TYPE_INT),

			'suscriptor' => array('type' => TYPE_BOOL,'filter' => true),

			'proveedor' => array('type' => TYPE_BOOL),

			'socio_local' => array('type' => TYPE_BOOL,'filter' => true),

			'prg_becas_old' => array('type' => TYPE_BOOL,'filter' => true),

			'becas_fecha_in' => array('type' => TYPE_DATE),
			'becas_fecha_out' => array('type' => TYPE_DATE),

			'colaborador_old' => array('type' => TYPE_BOOL,'filter' => true),

			'donante_old' => array('type' => TYPE_BOOL,'filter' => true),
			
			'numero_cuenta' => array('type' => TYPE_STRING),

			'estado' => array('type' => TYPE_BOOL, 'filter' => true),

			'observaciones' => array('type' => TYPE_STRING),

			'activo' => array('type' => TYPE_BOOL, 'filter' => true),

			'administrador' => array('type' => TYPE_BOOL,'filter' => true),

			'pass' => array('type' => TYPE_MD5),
			


		),
	);

	
	function __construct($_id = null) {
		$this->fecha_alta = date("Y-m-d H:i:s");
		parent::__construct($_id);		
	}

	public function verDatos(){
		echo 'id: '.$this->id_usuario.'<br>';
		echo 'tipo: '.$this->tipo_usuario.'<br>';
		echo 'fecha: '.$this->fecha_alta.'<br>';
		echo 'tipo alta: '.$this->id_tipo_alta.'<br>';
		echo 'nombre: '.$this->nombre.'<br>';
		echo 'nombre_corto: '.$this->nombre_corto.'<br>';
		echo 'id categoria: '.$this->id_categoria_usuario.'<br>';
		echo 'id rol: '.$this->id_rol.'<br>';
		echo 'delegacion'.$this->id_delegacion.'<br>';
		echo 'wev: '.$this->web.'<br>';
		echo 'cif: '.$this->cif.'<br>';
		echo 'primer apellido'.$this->primer_apellido.'<br>';
		echo 'segundo apellido: '.$this->segundo_apellido.'<br>';
		echo 'nacconl: '.$this->nacionalidad.'<br>';
		echo 'delegacion'.$this->fecha_nacimiento.'<br>';
		echo $this->genero.'<br>';
		echo $this->tratamiento.'<br>';
		echo 'delegacion'.$this->tfno_fijo.'<br>';
		echo $this->pre_internacional.'<br>';
		echo $this->tfno_movil.'<br>';
		echo 'delegacion'.$this->mail.'<br>';
		echo $this->twitter.'<br>';
		echo $this->horario_consulta.'<br>';
		echo 'delegacion'.$this->como_conocido.'<br>';
		echo $this->id_estudios.'<br>';
		echo $this->id_profesion.'<br>';
		echo 'delegacion'.$this->suscriptor.'<br>';
		echo $this->proveedor.'<br>';
		echo $this->socio_local.'<br>';
		echo 'delegacion'.$this->prg_becas_old.'<br>';
		echo 'delegacion'.$this->becas_fecha_in.'<br>';
		echo 'delegacion'.$this->becas_fecha_out.'<br>';
		echo 'delegacion'.$this->colaborador_old.'<br>';
		echo 'delegacion'.$this->donante_old.'<br>';
		echo $this->numero_cuenta.'<br>';
		echo $this->estado.'<br>';
		echo 'delegacion'.$this->observaciones.'<br>';
		echo $this->administrador.'<br>';
		echo $this->pass.'<br>';
		echo 'activo'.$this->activo.'<br>';
	}

	/*
	Devuele un array con todas las procedencias
	*/
	public static function selectAll($tabla = null,$where = null, $order = null)
	{
		return parent::selectAll(Usuario::$tabla,$where,$order);
	}

	public function delete($id)
	{
		$usuario = new Usuario($id);
		$usuario->activo = 0;
		$usuario->update($id);

	}
	

}
?>
