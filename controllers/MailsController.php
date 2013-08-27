<?php

class MailsController extends SimpleController {

	
	public $twig;

	function __construct($_twig) {
		$this->twig = $_twig;
		parent::__construct('Mail','MailsController',$_twig);
				
	}

	/*
	Actualiza una colección de correos electrónicos recibidos
	mediante POST
	*/
	public function updateMails()
	{
		$id_mail = $_POST['id_mail'];
		$id_usuario_mail =  $_POST['id_usuario_mail'];
		$etiqueta_mail =  $_POST['etiqueta_mail'];
		$mails =  $_POST['mail'];
		$orden_mail =  $_POST['orden_mail'];

		$i = 0;
		foreach ($id_mail as $key => $value) {
			$mail = new Mail($value);
			$mail->id_usuario = $id_usuario_mail[$i];
			$mail->etiqueta = $etiqueta_mail[$i];
			$mail->mail = $mails[$i];
			$mail->orden = $orden_mail[$i];
			$mail->update($value);

			if ($orden_mail[$i] == 0)
			{
				echo 'actualiza';
				$user = new Usuario($id_usuario_mail[$i]);
				$user->mail = $mails[$i];
				$user->update($user->id_usuario);
			}
			
			$i++;

			
		}
	}

		

}

?>