<?php

class DireccionesController extends SimpleController {

	
	public $twig;

	function __construct($_twig) {
		$this->twig = $_twig;
		parent::__construct('Direccion','DireccionesController',$_twig);
				
	}

	public function updateDirecciones()
	{
		$id_direccion = $_POST['id_direccion'];
		$id_usuario =  $_POST['id_usuario'];
		$alias =  $_POST['alias'];
		$direccion1 =  $_POST['direccion1'];
		$direccion2 =  $_POST['direccion2'];
		$cp = $_POST['cp'];
		$localidad =  $_POST['localidad'];
		$provincia =  $_POST['provincia'];
		$pais =  $_POST['pais'];
		$orden_direcciones =  $_POST['orden_direccion'];

		$i = 0;
		foreach ($id_direccion as $key => $value) {
			$direccion = new Direccion($value);
			$direccion->id_usuario = $id_usuario[$i];
			$direccion->alias = $alias[$i];
			$direccion->direccion1 = $direccion1[$i];
			$direccion->direccion2 = $direccion2[$i];
			$direccion->cp = $cp[$i];
			$direccion->localidad = $localidad[$i];
			$direccion->provincia = $provincia[$i];
			$direccion->pais = $pais[$i];
			$direccion->orde = $orden_direcciones[$i];
			$direccion->update($value);
			$i++;
		}
	}
		

}

?>