<?php

class PersonaController extends SimpleController {
	
	public $twig;

	function __construct($_twig) {
		$this->twig = $_twig;
		parent::__construct('Usuario','PersonaController',$_twig);
				
	}	
	
	/*
	genera una lista con todo el contenido de la tabla asociada al controlador
	*/
	public function genList($error = false, $template = null,$from = null,$where = null,$filtro = false)
	{
		#$query contine los campos SELECT de la consulta
		$actual = 0;
		$unidades = 20;
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

		if ($_COOKIE['filtro_usuario'] != '')
			$where = ($_COOKIE['filtro_usuario']).' and us.tipo_usuario = 0 GROUP BY us.nombre ';
		else
			$where = ' us.activo = 1 AND us.tipo_usuario = 0 GROUP BY us.nombre ';

		if ($_COOKIE['usuario_orden'] != '')
			$where .= 'ORDER BY '.$_COOKIE['usuario_orden'];
		else
			$where .= 'ORDER BY us.id_usuario';

		$where .= ' LIMIT 0,'.$unidades;

		parent::genList(
			$error,
			$query,
			$from,
			$where,
			'filtroUsuario.html');
	}	
	
	public function addForm()
	{
		
		$usuario = new Usuario();
		$telefonos = null;
		$mails = null;
		$direcciones = null;

		if (isset($_GET['id']))
		{
			$usuario = new Usuario($_GET['id']);
			$telefonos = Telefono::getTelefonosId($_GET['id'],'orden');
			$mails = Mail::getMailsId($_GET['id'],'orden');
			$direcciones = Direccion::getDireccionesId($_GET['id'],'orden');
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
			'direcciones' => $direcciones,
			'controller' => 'PersonaController',
		));
	}

	/*
	Añade una nueva Persona
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

				$this->genList();
			}
			else
				$this->genList('Se ha producido un error');
		}
		else
			$id = parent::add();
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
		$salida= 'location:'.$_SERVER['SCRIPT_NAME'].'?controller=PersonaController&action=genList';
		
		header($salida);
	}

}

?>