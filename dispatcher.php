<?php

if (!isset($_GET['controller']))
	echo $twig->render('index.html');
else
{
	try {
		$controller = new $_GET['controller']($twig);
		if (isset($_GET['action']))
			$controller->$_GET['action']();
		
	} catch (Exception $e) {
		
	}
}

?>