<?php

class OrganizacionController extends SimpleController {
	
	public $twig;

	function __construct($_twig) {
		$this->twig = $_twig;
		parent::__construct('Usuario','OrganizacionController',$_twig);
				
	}	
	
	/*
	genera una lista con todo el contenido de la tabla asociada al controlador
	*/
	public function genList($error = false, $template = null,$from = null,$where = null)
	{
		$query = sprintf("%s,%s,%s,%s",'us.id_usuario','nombre','estado','tlf.telefono' );
		parent::genList($error,$query,' usuario as us LEFT JOIN telefonos AS tlf ON tlf.id_usuario = us.id_usuario',' us.activo = 1 and us.tipo_usuario = 1 GROUP BY tlf.id_usuario');
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
			$mails =Mail::getMailsId($_GET['id'],'orden');
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
			'tipo_usuario' => 1,
			'direcciones' => $direcciones,
		));
	}

}

?>