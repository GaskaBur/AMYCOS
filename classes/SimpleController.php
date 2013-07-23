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
	public function genList($error = false)
	{
		$clase = new $this->class();

		echo $this->twig->render('listasimple.html', array(
				'error' => $error,
				'listado' => $clase->getAll(),
				'clase' => 'Mantenimiento tabla:  '.$this->class,
				'id' => 'id_'.strtolower($this->class),
				'controller' => $this->controller,
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
	public function add()
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
					$clase->$pst = utf8_encode($value);
				}
				if (!$error)
					$clase->add();
				$this->genList($error);
			}
		}
		
	}
	
}

?>