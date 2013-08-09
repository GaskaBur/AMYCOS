<?php

/*
* AMYCOS ERP
*
* @author: Sergio Gil Pérez
* @Company: Noises of Hill
* @year: 2013
*
*/

#Metodos comunes a los controladores, esta clase será heredada por los distintos controladores

class SimpleController {

	#Clase asociada al controlador
	private $class;
	
	#Objeto twig que se encarga de pintar  inteface
	private $twig;
	
	#Controlador activo que ha heredado la clase
	private $controller;

	/*
	Contructor, carga las propiedades de la clase
	*/
	function __construct($_class,$_controller, $_twig) {
		$this->class = $_class;
		$this->twig = $_twig;
		$this->controller = $_controller;			
	}

	/*
	genera una lista con todo el contenido de la tabla asociada al controlador a traves del 
	template listasimple.html
	*/
	public function genList($error = false, $query = null, $from = null,$where = null,$filtro = 'nullfilter.html',$pages = 0,$page_actual=-1)
	{
		
		$consulta = "";
		$clase = new $this->class();	
		
		if ($from == null)
			$from = strtolower($this->class);
				
		if ($query == null)
		{
			$listado = $clase->getAll();
			$consulta = sprintf('SELECT %s FROM %s','*',$clase->definition['table']);
		}
		else
		{
			//print(sprintf("select %s from %s where %s",$query,$from,$where));
			if ($where == null)
			{
				$consulta = sprintf("select %s from %s",$query,$from);
				$consulta =  substr($consulta, 0,strrpos($consulta, "LIMIT"));
				$listado = DB::getInstance()->executeQ(sprintf("select %s from %s",$query,$from));
			}
			else
			{
				$consulta = sprintf("select %s from %s where %s",$query,$from,$where);
				$consulta =  substr($consulta, 0,strrpos($consulta, "LIMIT"));
				$listado = DB::getInstance()->executeQ(sprintf("select %s from %s where %s",$query,$from,$where));				
			}
		}		
		
		
		echo $this->twig->render('listasimple.html', array(
				'error' => $error,
				'listado' => $listado,
				'clase' => 'Mantenimiento tabla:  '.$this->class,
				'id' => 'id_'.strtolower($this->class),
				'controller' => $this->controller,
				'filtro' => $filtro,
				'paginas' => $pages,
				'actual' => $page_actual,
				'consulta' => $consulta,
		));
	}

	/*
	Metodo que permite borrar un registro en base a la id que llega por GET	
	*/
	public function del()
	{
		if (isset($_GET['id']))
		{
			
			$clase = new $this->class();
			$clase->delete($_GET['id']);
			$this->genList();
		}
	}

	/*
	Esto método genera un formulario a trqavés de addForm.html con los campos
	asociados a la tabla del controlador
	*/
	public function addForm()
	{
		$clase = new $this->class();
		echo $this->twig->render('addForm.html', array(
				'form' => $clase->genForm($this->controller,'add',$this->class),
				'clase' => 'Mantenimiento tabla:  '.$this->class,
				'id' => 'id_'.strtolower($this->class),
				'controller' => $this->controller,
		));
	}

	
	/*
	recoge la información enviada a través del formulario generado en addForm()
	y realiza el alta o actualización de la tabla según corresponda.
	El criterio será que si llega un id mediante GET se tratá de una actualización, 
	si no será un nuevo registro.
	*/
	public function add($return = null)
	{
		if(isset($_GET['id']))
		{
			$clase = new $this->class();
			$error = false;
			foreach ($_POST as $pst => $value) {
				if (isset($clase->definition['fields'][$pst]['isRequired']))
				{
					if ($value == "")
						$error = true;
				}
				$clase->$pst = $value;
			}
			if (!$error)
				$clase->update($_GET['id']);
			$this->genList();
		}
		else
		{
			if(isset($_POST))
			{
				$clase = new $this->class();
				$error = false;
				foreach ($_POST as $pst => $value) {
					if (isset($clase->definition['fields'][$pst]['isRequired']))
					{
						if ($value == "")
							$error = true;
					}
					if (is_string($value))
						$clase->$pst = utf8_encode($value);
				}
				$exit = -1;
				if (!$error)
					$exit = $clase->add();
				
				if ($return == null)
					$this->genList($error);
				else
					return $exit;
			}
		}
		
	}

	public function ajasAdd()
	{
		$clase = new $this->class();
		$error = false;
		foreach ($_POST as $pst => $value) {
			if (isset($clase->definition['fields'][$pst]['isRequired']))
			{
				if ($value == "")
					$error = true;
			}
			$clase->$pst = utf8_encode($value);
		}
		if (!$error)
			print($clase->add());
		else
			print(-1);
	}

	/*
	Proceso de filtro para la tabla Usuarios.
	*/
	public function filter(){
		
		$filtro = "";
		$fecha_nacimiento_in = '0000-00-00';
		$fecha_nacimiento_out = '9999-99-99';
		 
		setcookie("filtro_fecha_nacimiento_desde","", time()-3600);
		setcookie("filtro_fecha_nacimiento_hasta","", time()-3600);
	
		if ($_POST['filtro_fecha_nacimiento_desde'] != '')
		{
			$fecha_nacimiento_in = $_POST['filtro_fecha_nacimiento_desde'];
			setcookie("filtro_fecha_nacimiento_desde", $fecha_nacimiento_in, time()+3600); //La cookie expira en una hora
		}

		

		if ($_POST['filtro_fecha_nacimiento_hasta'] != '')
		{
			$fecha_nacimiento_out = $_POST['filtro_fecha_nacimiento_hasta'];
			setcookie("filtro_fecha_nacimiento_hasta", $fecha_nacimiento_out, time()+3600); //La cookie expira en una hora
		}
		
		$filtro .= "(us.fecha_nacimiento >= '".$fecha_nacimiento_in."' AND us.fecha_nacimiento < '".$fecha_nacimiento_out."') ";

		$filtro .= $_POST['filtro_estado'];
		setcookie("filtro_estado",$_POST['filtro_estado'], time()+3600);

		$filtro .= $_POST['filtro_activo'];
		setcookie("filtro_activo",$_POST['filtro_activo'], time()+3600);

		if ($_POST['filtro_id_categoria_usuario'] == 0)
			$filtro .= 'AND us.id_categoria_usuario BETWEEN 0 AND 9999999999 ';
		else
			$filtro .= 'AND us.id_categoria_usuario BETWEEN '.$_POST['filtro_id_categoria_usuario'].' AND '.$_POST['filtro_id_categoria_usuario'].' ';
		setcookie("filtro_id_categoria_usuario",$_POST['filtro_id_categoria_usuario'], time()+3600);

		if ($_POST['filtro_id_tipo_alta'] == 0)
			$filtro .= 'AND us.id_tipo_alta BETWEEN 0 AND 9999999999 ';
		else
			$filtro .= 'AND us.id_tipo_alta BETWEEN '.$_POST['filtro_id_tipo_alta'].' AND '.$_POST['filtro_id_tipo_alta'].' ';
		setcookie("filtro_id_tipo_alta",$_POST['filtro_id_tipo_alta'], time()+3600);

		if ($this->controller == 'PersonaController')
		{
			$filtro .= "AND ( (us.nombre LIKE '%".$_POST['filtro_nombre']."%') OR (us.primer_apellido LIKE '%".$_POST['filtro_nombre']."%') OR (us.segundo_apellido LIKE '%".$_POST['filtro_nombre']."%')) ";
			setcookie("filtro_nombre",$_POST['filtro_nombre'], time()+3600);
		}
		else
		{
			$filtro .= "AND us.nombre LIKE '%".$_POST['filtro_nombre']."%'";
			setcookie("filtro_nombre",$_POST['filtro_nombre'], time()+3600);
		}

		$filtro .= "AND us.nacionalidad LIKE '%".$_POST['filtro_nacionalidad']."%' ";
		setcookie("filtro_nacionalidad",$_POST['filtro_nacionalidad'], time()+3600);

		if ($_POST['filtro_id_rol'] == 0)
			$filtro .= 'AND us.id_rol BETWEEN 0 AND 9999999999 ';
		else
			$filtro .= 'AND us.id_rol BETWEEN '.$_POST['filtro_id_rol'].' AND '.$_POST['filtro_id_rol'].' ';
		setcookie("filtro_id_rol",$_POST['filtro_id_rol'], time()+3600);

		if ($_POST['filtro_mail'] != '')
		{
			$filtro .="AND ma.mail LIKE '%".$_POST['filtro_mail']."%'";
			setcookie("filtro_mail",$_POST['filtro_mail'], time()+3600);
		}

		if ($_POST['filtro_localidad'] != '')
		{
			$filtro .="AND di.localidad LIKE '%".$_POST['filtro_localidad']."%'";
			setcookie("filtro_localidad",$_POST['filtro_localidad'], time()+3600);
		}

		if ($_POST['filtro_provincia'] != '')
		{
			$filtro .="AND di.provincia LIKE '%".$_POST['filtro_provincia']."%'";
			setcookie("filtro_provincia",$_POST['filtro_provincia'], time()+3600);
		}
		
		if(isset($_POST['filtro_administrador']))
		{
			$filtro .= "AND us.administrador = 1 ";
			setcookie("filtro_administrador","1");
		}
		else
			setcookie("filtro_administrador","0");

		
		if(isset($_POST['filtro_suscriptor']))
		{
			$filtro .= "AND us.suscriptor = 1 ";
			setcookie("filtro_suscriptor","1");
		}
		else
			setcookie("filtro_suscriptor","0");

		setcookie("filtro_socio_local","0", time()-3600);
		if(isset($_POST['filtro_socio_local']))
		{
			$filtro .= "AND us.socio_local = 1 ";
			setcookie("filtro_socio_local","1", time()+3600);
		}
		
		setcookie("filtro_prg_becas_old","0", time()-3600);
		if(isset($_POST['filtro_prg_becas_old']))
		{
			$filtro .= "AND us.prg_becas_old = 1 ";
			setcookie("filtro_prg_becas_old","1", time()+3600);
		}

		setcookie("filtro_colaborador_old","0", time()-3600);
		if(isset($_POST['filtro_colaborador_old']))
		{
			$filtro .= "AND us.colaborador_old = 1 ";
			setcookie("filtro_colaborador_old","1", time()+3600);
		}

		setcookie("filtro_donante_old","0", time()-3600);
		if(isset($_POST['filtro_donante_old']))
		{
			$filtro .= "AND us.donante_old = 1 ";
			setcookie("filtro_donante_old","1", time()+3600);
		}
		

		setcookie("filtro_voluntario","0", time()-3600);
		if(isset($_POST['filtro_voluntario']))
		{
			$filtro .= "AND vol.id_voluntario IS NOT NULL ";
			setcookie("filtro_voluntario","1", time()+3600);
		}

		setcookie("filtro_donante","0", time()-3600);
		if(isset($_POST['filtro_donante']))
		{
			$filtro .= "AND don.id_donacion IS NOT NULL ";
			setcookie("filtro_donante","1", time()+3600);
		}

		setcookie("filtro_colaborador","0", time()-3600);
		if(isset($_POST['filtro_colaborador']))
		{
			$filtro .= "AND col.id_colaboracion IS NOT NULL ";
			setcookie("filtro_colaborador","1", time()+3600);
		}

		setcookie("filtro_usuario",$filtro,time()+3600);
		//$filtro .= '<a href="http://localhost/amycos/?controller=PersonaController&action=genList">http://localhost/amycos/?controller=PersonaController&action=genList</a>';
		//echo '<br>resultado: '.$filtro.'<br>';
		$salida= 'location:'.$_SERVER['SCRIPT_NAME'].'?controller='.$this->controller.'&action=genList';
		
		header($salida);

	}

	/*
	Resetea todos los filtros de la tabla usuario
	*/
	public function resetFilter()
	{
		setcookie("filtro_usuario");
		setcookie("filtro_fecha_nacimiento_desde");
		setcookie("filtro_fecha_nacimiento_hasta");
		setcookie("filtro_estado");
		setcookie("filtro_activo");
		setcookie("filtro_id_categoria_usuario");
		setcookie("filtro_id_tipo_alta");
		setcookie("filtro_nombre");
		setcookie("filtro_nacionalidad");
		setcookie("filtro_id_rol");
		setcookie("filtro_administrador");
		setcookie("filtro_suscriptor");
		setcookie("filtro_socio_local");		
		setcookie("filtro_prg_becas_old");
		setcookie("filtro_colaborador_old");
		setcookie("filtro_donante_old");		
		setcookie("filtro_voluntario");
		setcookie("filtro_donante");
		setcookie("filtro_colaborador");
		setcookie("filtro_mail");
		setcookie("filtro_localidad");
		setcookie("filtro_provincia");
		setcookie("usuario_orden");

		$salida= 'location:'.$_SERVER['SCRIPT_NAME'].'?controller='.$this->controller.'&action=genList';
		
		header($salida);
	}
	
}

?>