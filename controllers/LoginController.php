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
			$user = $_POST['userID'];
			$pass = $_POST['userPASS'];

			//Busca usuario por nombre o por mail
			$sql = sprintf("SELECT ma.id_usuario, us.pass, us.nombre
				FROM mails as ma INNER JOIN usuario AS us ON us.id_usuario = ma.id_usuario
				WHERE ma.mail = '%s' AND us.administrador = 1 AND us.activo = 1 AND us.estado = 1
				LIMIT 0,1",$user);
			$result = DB::getInstance()->executeQ($sql);
			
			if (count($result) != 0)
			{
				//Se ha encontrado usuario comprobar pass
				if ($result[0]['pass'] == md5($pass))
				{
					//Login correcto
					$_SESSION['username'] = $result[0]['nombre'];
					header('location:index.php');
				}
			}
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