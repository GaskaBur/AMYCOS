<?php

class VoluntarioController extends UsuarioController {
	
	public $twig;

	function __construct($_twig) {
		$this->twig = $_twig;
		parent::__construct('Usuario','VoluntarioController',$_twig);
				
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

		if ($this->tipo_usuario != -1)
		{
			$where = ' us.activo = 1 AND vol.id_voluntario IS NOT NULL GROUP BY us.id_usuario ';
			if (isset($_COOKIE['filtro_usuario']))
			{
				if ($_COOKIE['filtro_usuario'] != '')
					$where = ($_COOKIE['filtro_usuario']).' AND vol.id_voluntario IS NOT NULL GROUP BY us.id_usuario ';
			}
		}
		else
		{
			$where = ' us.activo = 1 AND vol.id_voluntario IS NOT NULL GROUP BY us.id_usuario ';
			if (isset($_COOKIE['filtro_usuario']))
			{
				if ($_COOKIE['filtro_usuario'] != '')
					$where = ($_COOKIE['filtro_usuario']).' AND vol.id_voluntario IS NOT NULL 
				GROUP BY us.id_usuario ';
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
		parent::genList(
			$error,
			$query,
			$from,
			$where,
			'filtroUsuario.html',
			$paginas,
			$actual);
	}	

	public function add($return = null)
	{
		
		$id =  parent::add();

		$voluntario = new Voluntario();
		$voluntario->id_usuario = $id;
		$voluntario->add();

		$this->genList();
	}	

}

?>