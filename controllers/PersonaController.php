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
	public function genList($error = false, $template = null,$from = null,$where = null)
	{
		#$query contine los campos SELECT de la consulta
		$query = sprintf("%s,%s,%s,%s,%s,%s",'us.id_usuario','us.nombre','us.primer_apellido','us.segundo_apellido','ma.mail', 'tlf.telefono' );
		# genList(error, select, from, where).
		parent::genList($error,$query,' usuario as us LEFT JOIN telefonos AS tlf ON tlf.id_usuario = us.id_usuario LEFT JOIN mails AS ma ON ma.id_usuario = us.id_usuario',' us.activo = 1 and us.tipo_usuario = 0 GROUP BY tlf.id_usuario');
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

}

?>