<?php
/*
* AMYCOS ERP
*
* @author: Sergio Gil Pérez
* @Company: Noises of Hill
* @year: 2013
*
* Está clase se encarga del sistema de login y logout de usuarios
*/
class LoginController {

	
	/*
	Gestiona el login de un usuario
	recibe por POST usuaro y contraseña.
	*/
	public function login()
	{
		if (isset($_POST['userID']) && isset($_POST['userPASS']))
		{
			//Proceso de validación de Login
			echo $_POST['userID'];
			echo $_POST['userPASS'];
			$_SESSION['username'] = 'Sergio';
			header('location:index.php');

		}
		else
			header('location:index.php');
	}

	/*
	Desconecta y destruye la sessión actual
	*/
	public function logout()
	{
		session_destroy();
		header('location:index.php');
	}


		

}

?>