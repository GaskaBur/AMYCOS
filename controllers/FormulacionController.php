<?php

class FormulacionController extends SimpleController {

	
	public $twig;

	function __construct($twig) {
		$this->twig = $twig;
		parent::__construct('Formulacion','FormulacionController',$twig);
				
	}

	/*
	Override del metodo padre para generar la asociación de archivos y Formulaciones
	*/
	public function addForm()
	{
		$clase = new Formulacion();
		$formulario = $clase->genForm('FormulacionController','add',$clase,false);

		//Asociación de archivos con Formulaciones 
		//Listado de archivos
		if (isset($_GET['id']))
		{
			$formulario .= '<h3>Listado de Archivos Asociados</h3>';
			//$archivos = Formulacion_Archivo::getArchivos($_GET['id']);
		}

		//Preparando repositorio de archivos
		$categorias = Categoria_Archivo::selectAll();
		$archivos = array();
		foreach ($categorias as $key => $value) {
			$archivos[$value['id_categoria_archivo']] = array();
			$archivos[$value['id_categoria_archivo']]['descripcion'] = $value['descripcion'];
			$archivos[$value['id_categoria_archivo']]['id_categoria_archivo'] = $value['id_categoria_archivo'];
			$archivos[$value['id_categoria_archivo']]['archivos'] = Archivo::getFilesCategory($value['id_categoria_archivo']);
		}
		$formulario .= '<a href="#asociarArchivos" role="button" class="btn" data-toggle="modal">Asociar archivos</a>';

		$formulario .= '<div><ul id="archivosAsociados">';
		$archivosAsociados = Archivo::getFilesFormulacion($_GET['id']);
		foreach ($archivosAsociados as $key => $value) {
			$formulario .= '<li>'.$key."-".$value->nombre.'</li>';
		}
		$formulario .= '</ul></div>';
		$formulario .= '<a href="#asociarArchivos" role="button" class="btn" data-toggle="modal">Asociar archivos</a>';
        $formulario .= $this->twig->render('asociarArchivos.html', array('archivos' => $archivos,'id_formulacion' => $_GET['id']));
   		

     	$formulario .= '<input type="submit" value="Enviar"/>';
			$formulario .= '</fieldset>';
			$formulario .= '</form>';
   
		
		echo $this->twig->render('addForm.html', array(
				'form' => $formulario,
				'clase' => 'Mantenimiento tabla:  Formulaciones',
				'id' => 'id_formulacion',
				'controller' => 'FormulacionController',
				'cat_archivo' => (isset($_GET['cat_archivo'])) ? $_GET['cat_archivo'] : null, //Este Cat está añadido para el repositorio de archivos
		));
	}

	public function genList($error = false, $query = null, $from = null,$where = null,$filtro = 'nullfilter.html',$pages = 0,$page_actual=-1)
	{
		$query = "fo.id_formulacion, fo.descripcion, DATE_FORMAT(fo.fecha_formulacion, '%d/%m/%Y') as fecha_formulacion, 
			DATE_FORMAT(fo.fecha_presentacion, '%d/%m/%Y') as fecha_presentacion, 
			DATE_FORMAT(fo.fecha_resolucion, '%d/%m/%Y') as fecha_resolucion, es.descripcion as estado, us.mail";
		$from = " formulaciones as fo LEFT JOIN usuario as us ON fo.id_usuario = us.id_usuario";
		$from .= " LEFT JOIN estados_formulacion as es ON fo.id_estado_formulacion = es.id_estado_formulacion";
		parent::genList(false,$query,$from);
	}

	/* BLOQUE QUE CREO QUE NO SE USA, REVISAR MAS ADELANTE.
	public function asociarArchivos(){
		echo $this->twig->render('asociarArchivos.html', array());
	}
	*/

	public function asociarArchivos()
	{
		if (isset($_POST['id_formulacion']))
		{
			$idFormulacion = $_POST['id_formulacion'];
			if ($idFormulacion != -1)
			{
				$files = array();
				if (isset($_POST['files']))
				{
					$files = $_POST['files'];
				}
				$sql = sprintf("DELETE FROM formulaciones_archivos WHERE id_formulacion = %d",$idFormulacion);
				DB::getInstance()->execute($sql);
				foreach ($files as $value) {
					$sql = sprintf("INSERT INTO formulaciones_archivos VALUES (%d,%d)",$idFormulacion,$value);
					DB::getInstance()->execute($sql);
				}
			}
		}
	}

		

}

?>