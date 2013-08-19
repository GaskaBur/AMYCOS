<?php

class ArchivosController extends SimpleController {

	
	public $twig;

	function __construct($twig) {
		$this->twig = $twig;
		parent::__construct('Archivo','ArchivosController',$twig);
				
	}
	
	/*
	Esto método genera un formulario a trqavés de addForm.html con los campos
	asociados a la tabla del controlador
	*/
	public function addForm()
	{
		if (!isset($_GET['id']))
		{
			echo $this->twig->render('addForm.html', array(
					'form' => $this->genForm(),
					'clase' => 'Mantenimiento tabla:  Archivos',
					'id' => 'id_archivo',
					'controller' => 'ArchivosController',
			));
		}
		else
		{
			//Devuelve un archivo.
			$archivo = new Archivo($_GET['id']);
			$path =  _FILE_DIR_.'/'.$archivo->fecha_alta;
			echo $path;

			if (file_exists($path)) {
			    header('Content-Description: File Transfer');
			    header('Content-Type: '.$archivo->header);
			    header('Content-Disposition: attachment; filename='.basename(utf8_encode($archivo->nombre)));
			    header('Content-Transfer-Encoding: binary');
			    header('Expires: 0');
			    header('Cache-Control: must-revalidate');
			    header('Pragma: public');
			    header('Content-Length: ' . filesize($path));
			    ob_clean();
			    flush();
			    readfile($path);
			    exit;
			}
			//readfile($path);
			//header('location:'.$path);

			//file_put_contents($archivo->nombre, fopen($path));
		}
	}
	
	private function genForm()
	{
		$output = '<form action="?controller=ArchivosController&action=uploadFile&cat_archivo='.$_GET['cat_archivo'].'" method="post" enctype="multipart/form-data">';
		$output .= '<fieldset>';
		$output .= '<label>Seleccione el archivo</label>';
		$output .= '<input type="file" name="archivo[]" multiple />';
		$output .= '<input type="hidden" id="cat_archivo" name="cat_archivo" value="'.$_GET['cat_archivo'].'" />';
		$output .= '<br>';
		$output .= '<input type="submit" value="Enviar"/>';
		$output .= '</fieldset>';		
		$output .= '</form>';
		return $output;
	}
	
	/*
	Gestiona la subida de archivos
	*/
	public function uploadFile(){
		//Subir Archivo
		//echo 'que Pasa';
		//echo $_POST['archivo'];
		$subidos =  count($_FILES['archivo']['name']);
		$proceso = 0;
		$error = false;
		foreach($_FILES['archivo']['name'] as $key => $value){
			
			$nombreclean=htmlspecialchars('imagen');

			$uploaddir = _FILE_DIR_;
			
			$filesize = $_FILES['archivo']['size'][$proceso];
			$filename = str_replace(' ','_',trim($_FILES['archivo']['name'][$proceso]));
			
			if($filesize <= _FILE_MAX_)
			{
				if($filesize > 0)
				{
					
						//ereg(".jpeg", $filename)
						$extension =  substr(strrchr($filename, '.'), 1);
						$nameFinal = date('YmdHis').'_'.$proceso;
						$uploadfile = $uploaddir .'/'. $nameFinal;
						
					    if (move_uploaded_file($_FILES['archivo']['tmp_name'][$proceso], $uploadfile)) {
							// 'success';
							$archivo = new Archivo();
							$archivo->nombre = $filename;
							$archivo->extension = $extension;
							$archivo->header = $_FILES['archivo']['type'][$proceso];
							$archivo->fecha_alta = date('YmdHis').'_'.$proceso;
							$archivo->id_usuario = 0;
							$archivo->descripcion = '';
							$archivo->id_categoria_archivo = $_POST['cat_archivo'];
							$archivo->add();
							

							
						} else {
							$error = true;
							
						}
						
					
				}
			}
			else 
			{
				print("<br><br>El archivo que ha intentado adjuntar es mayor de "._FILE_MAX_." bytes, si desea cambie el tamaño del archivo y vuelva a intentarlo.");
			}
			$proceso++;
		}
		if (!$error)
			$this->genList(false,'','archivos','id_categoria_archivo = '.$_POST['cat_archivo']);
		else
			$this->genList('Se ha producido un error');
	}

	/*
	Carga los archivos de una determinada Categoría
	*/
	public function genList($error = false, $query = null, $from = null,$where = null,$filtro = 'nullfilter.html',$pages = 0,$page_actual=-1)
	{
		if (isset($_GET['cat_archivo']))
			$cat = $_GET['cat_archivo'];
		else
			$cat = $_POST['cat_archivo'];
		parent::genList(false,'id_archivo,nombre,fecha_alta','archivos','id_categoria_archivo = '.$cat);
	}

	/*
	Metodo que permite borrar un registro en base a la id que llega por GET	
	*/
	public function del()
	{
		if (isset($_GET['id']))
		{
			
			$clase = new Archivo($_GET['id']);
			$clase->delete($_GET['id']);
			$this->genList(false,'','archivos','id_categoria_archivo = '.$_GET['id']);
			@unlink(_FILE_DIR_.'/'.$clase->fecha_alta);
		}
	}
	
	
		

}

?>