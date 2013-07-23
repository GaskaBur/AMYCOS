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
	public function genList($error = false)
	{
		$query = sprintf("%s,%s,%s",'id_usuario','nombre','estado' );
		$listado = DB::getInstance()->executeQ(sprintf("select %s from usuario where activo = 1",$query));
		
		echo $this->twig->render('listasimple.html', array(
				'error' => $error,
				'listado' => $listado,
				'clase' => 'Mantenimiento tabla:  Usuario',
				'id' => 'id_usuario',
				'controller' => 'UsuarioController',
		));
	}

	public function addForm()
	{
		
		$usuario = new Usuario();
		$telefonos = null;
		$mails = null;
		if (isset($_GET['id']))
		{
			$usuario = new Usuario($_GET['id']);
			$telefonos = Telefono::getTelefonosId($_GET['id'],'orden');
			$mails =Mail::getMailsId($_GET['id'],'orden');
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
		));
	}



		

}

?>