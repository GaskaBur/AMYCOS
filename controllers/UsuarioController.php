<?php

class UsuarioController extends SimpleController {
	
	public $twig;
	public $clase;
	public $controller;
	public $tipo_usuario = -1; //-1 = todos los usuarios, 0 = Personas, 1 = Organizaciones

	function __construct($_clase = 'Usuario',$_controller = 'UsuarioController' ,$_twig) {
		$this->twig = $_twig;
		$this->clase = $_clase;
		$this->controller = $_controller;
		if ($this->controller == 'PersonaController')
			$this->tipo_usuario = 0;
		else if ($this->controller == 'OrganizacionController')
			$this->tipo_usuario = 1;
		parent::__construct($this->clase,$this->controller,$_twig);
				
	}

	public function formUsuario()
	{
		
		
		echo $this->twig->render('usuario.html', array(
			'tipos_alta' => Tipo_Alta::selectAll(),
			'delegaciones' => Delegacion::selectAll(),
			'categorias' => Categoria_Usuario::selectAll(),
			'roles' => Rol::selectAll(),
			'estudios' => Estudio::selectAll(),
			'profesiones' => Profesion::selectAll(),
		));
	}


	/*
	genera una lista con todo el contenido de la tabla asociada al controlador
	*/
	public function genList($error = false, $template = null, $from = null,$where = null,$filtro = false, $page = 0, $page_actual = -1)
	{
		#$query contine los campos SELECT de la consulta
		$actual = 0;
		if (isset($_GET['page']))
			$actual = $_GET['page'];
		$paginas = 0;

		$query = sprintf("%s,%s,%s,%s,%s,%s,%s,%s,%s,%s",
			'us.id_usuario',
			'us.nombre',
			'us.primer_apellido',
			'us.segundo_apellido',
			'ma.mail', 
			'tlf.telefono',
			'di.localidad',
			'di.provincia',
			'vol.id_voluntario',
			'us.estado' );

		# genList(error, select, from, where).
		$from = ' usuario as us ';
		$from .= 'LEFT JOIN (SELECT * FROM telefonos ORDER BY orden) AS tlf ON tlf.id_usuario = us.id_usuario ';
		$from .= 'LEFT JOIN (SELECT * FROM mails ORDER BY orden) AS ma ON ma.id_usuario = us.id_usuario ';
		$from .= 'LEFT JOIN (SELECT * FROM direcciones ORDER BY orden) AS di ON di.id_usuario = us.id_usuario ';
		$from .= 'LEFT JOIN voluntarios AS vol ON vol.id_usuario = us.id_usuario ';
		$from .= 'LEFT JOIN donaciones AS don ON don.id_usuario = us.id_usuario ';
		$from .= 'LEFT JOIN colaboraciones AS col ON col.id_usuario = us.id_usuario ';

		if ($this->controller != 'VoluntarioController')
		{
			if ($this->tipo_usuario != -1)
			{
				$where = ' us.activo = 1 AND us.tipo_usuario = '.$this->tipo_usuario.' GROUP BY us.id_usuario ';
				if (isset($_COOKIE['filtro_usuario']))
				{
					if ($_COOKIE['filtro_usuario'] != '')
						$where = ($_COOKIE['filtro_usuario']).' and us.tipo_usuario = '.$this->tipo_usuario.' GROUP BY us.id_usuario ';
				}
			}
			else
			{
				$where = ' us.activo = 1 GROUP BY us.id_usuario ';
				if (isset($_COOKIE['filtro_usuario']))
				{
					if ($_COOKIE['filtro_usuario'] != '')
						$where = ($_COOKIE['filtro_usuario']).' GROUP BY us.id_usuario ';
				}
			}

				
		
			if (isset($_COOKIE['usuario_orden']))
			{
				if ($_COOKIE['usuario_orden'] != '')
					$where .= 'ORDER BY '.$_COOKIE['usuario_orden'];
			}
			else
				$where .= 'ORDER BY us.id_usuario';
				

			
			$q = sprintf('SELECT %s FROM %s WHERE %s',$query,$from,$where);
			$array = DB::getInstance()->executeQ($q);
			$registros = count($array);		
			$paginas = $registros / PAGINAS_USUARIOS;
			$paginas = (int)$paginas;
			if (($registros / PAGINAS_USUARIOS ) > $paginas)
				$paginas ++;
			

			$where .= ' LIMIT '.($actual * PAGINAS_USUARIOS).','.PAGINAS_USUARIOS;
		}
		else
			$paginas = $page;

		parent::genList(
			$error,
			$query,
			$from,
			$where,
			'filtroUsuario.html',
			$paginas,
			$actual);
	}

	public function addForm()
	{
		
		$usuario = new Usuario();
		$telefonos = null;
		$mails = null;
		$direcciones = null;
		$voluntario = null;

		if (isset($_GET['id']))
		{
			$usuario = new Usuario($_GET['id']);
			$telefonos = Telefono::getTelefonosId($_GET['id'],'orden');
			$mails = Mail::getMailsId($_GET['id'],'orden');
			$direcciones = Direccion::getDireccionesId($_GET['id'],'orden');

			$sql = sprintf("SELECT * FROM %s WHERE id_usuario = %d",'voluntarios',$_GET['id']);
			$voluntario = DB::getInstance()->executeQ($sql);
		}
		echo $this->twig->render('usuario.html', array(
			'tipos_alta' => Tipo_Alta::selectAll(),
			'delegaciones' => Delegacion::selectAll(),
			'categorias' => Categoria_Usuario::selectAll(),
			'roles' => Rol::selectAll(),
			'estudios' => Estudio::selectAll(),
			'profesiones' => Profesion::selectAll(),
			'telefonos' => $telefonos,
			'mails' => $mails,
			'usuario' => $usuario,
			'tipo_usuario' => $this->tipo_usuario,
			'direcciones' => $direcciones,
			'voluntario' => $voluntario,
			'controller' => $this->controller,
		));
	}

	/*
	Añade un nuevo Usuario
	*/
	public function add($return = null){
		if(!isset($_GET['id']))
		{
			//Doy de alta el usuario
			$id = parent::add(1);

			// Si no existe error en el alta del usuario se da de alta su primer mail y telefono si existe.
			if ($id != -1)
			{
				//Alta del correo incial si existe
				if (isset($_POST['mail']))
				{
					if ($_POST['mail'] != '')
					{
						$mail = new Mail();
						$mail->id_usuario = $id;
						$mail->mail = $_POST['mail'];
						$mail->add();
					}
				}

				//Alta del primer teléfono si exsite, prioirizando el móvil.
				if (isset($_POST['tfno_movil']) && isset($_POST['tfno_fijo']))
				{
					if ($_POST['tfno_movil'] != '')
					{
						$telefono = new Telefono();
						$telefono->id_usuario = $id;
						$telefono->telefono = $_POST['tfno_movil'];
						$telefono->add();
					}
					else if ($_POST['tfno_fijo'] != '')
					{
						$telefono = new Telefono();
						$telefono->id_usuario = $id;
						$telefono->telefono = $_POST['tfno_fijo'];
						$telefono->add();
					}

				}

				if ($this->controller != 'VoluntarioController')
					$this->genList();
			}
			else
				$this->genList('Se ha producido un error');
		}
		else
			$id = parent::add();

		return $id;
	}

	public function order() {
		$key = $_GET['key'];
		if ($key == 'localidad' || $key == 'provincia')
			$pre = 'di.';
		else if ($key == 'telefono')
			$pre = 'tlf.';
		else if ($key == 'mail')
			$pre = 'ma.';
		else if ($key == 'id_voluntario')
			$pre = 'vol.';
		else
			$pre = 'us.';

		$key = $pre.$key;
		setcookie("usuario_orden",$key, time()+3600);
		$salida= 'location:'.$_SERVER['SCRIPT_NAME'].'?controller='.$this->controller.'&action=genList';
		
		header($salida);
	}

		

}

?>