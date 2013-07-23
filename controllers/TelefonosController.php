<?php

class TelefonosController extends SimpleController {

	
	public $twig;

	function __construct($_twig) {
		$this->twig = $_twig;
		parent::__construct('Telefono','TelefonosController',$_twig);
				
	}

	public function updateTelefonos()
	{
		$id_telefono = $_POST['id_telefono'];
		$id_usuario =  $_POST['id_usuario'];
		$etiqueta =  $_POST['etiqueta'];
		$telefonos =  $_POST['telefono'];
		$orden_telefonos =  $_POST['orden_telefono'];

		$i = 0;
		foreach ($id_telefono as $key => $value) {
			$telefono = new Telefono($value);
			$telefono->id_usuario = $id_usuario[$i];
			$telefono->etiqueta = $etiqueta[$i];
			$telefono->telefono = $telefonos[$i];
			$telefono->orden = $orden_telefonos[$i];
			$telefono->update($value);
			$i++;
		}
	}

	


		

}

?>