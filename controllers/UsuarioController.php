<?php

class UsuarioController extends SimpleController {

	
	public $twig;

	function __construct($_twig) {
		$this->twig = $_twig;
		parent::__construct('usuario','UsuarioController',$_twig);
				
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
		$query = sprintf("%s,%s,%s",'id_usuario','nombre','estado' );
		parent::genList($error,null,$query,' activo = 1');
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
		));
	}

	public function add($return = null){
		$id = parent::add(1);

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
	}



		

}

?>