<?php

//Proceso de login
//¿Se iniciado session?
if (!isset($_SESSION['id_usuario']))
{
	//¿Se ha intentado iniciar session?
	if (@$_GET['controller'] == 'LoginController') {
		try {
			$controller = new $_GET['controller']($twig);
			if (isset($_GET['action']))
				$controller->$_GET['action']();
			
		} catch (Exception $e) {
			
		}
	}
	else
		//Enviar a pantalla de login
		echo $twig->render('login.html');
}
else
{
	//Usuario Logeado en el sistema
	if (!isset($_GET['controller']))
		echo $twig->render('index.html');

	else 
	{
		if ($_GET['controller'] == 'UsuarioController') {
			try {
				$controller = new $_GET['controller']('Usuario','UsuarioController',$twig);
				if (isset($_GET['action']))
					$controller->$_GET['action']();
				
			} catch (Exception $e) {
				
			}
		}

		else
		{
			try {
				$controller = new $_GET['controller']($twig);
				if (isset($_GET['action']))
					$controller->$_GET['action']();
				
			} catch (Exception $e) {
				
			}
		}
	}
}

?>