<?php
session_start(); // al volver al index si existe una session, esta sera destruida, existen formas de conservarlas como con un if(session_start()!= NULL). Pero por el momento para el ejemplo no es valido.
//session_destroy(); // Se destruye la session existente de esta forma no permite el duplicado.

/**
@Autor: Sergio Gil Pérez
@Company: Noises Of Hill
@ 2013
@ Amycos
*/

/**
#Power by nicolaspar 2007  // Esta funcion sirve s los archvios de una carpeta.
Esta función incluye todos los archivos .php de la carpeta especificada en $path
*/
function require_once_dir( $path ){
    $dir = dir($path);
    while( ( $file = $dir->read() ) !== false )
        if( is_file( $path .'/'. $file ) and preg_match( '/^(.+)\.php$/i' , $file ) )
            require_once( $path .'/'. $file );
    $dir->close();
}

//CLASES Y UTILS - Incluyo clases y utils que utilizaré en la aplicación ---------------------------------------------------		
require_once_dir( 'config' );  #Incluye todas las clases que definen los valores de configuración.
require_once_dir( 'utils' );	#Incluye todos los .pnp de la carpeta utils -> utilidades varias (errores, logs, etc...)
require_once_dir( 'models/DB'); #Incluye Motor para conectar con Base de datos.
require_once_dir( 'models');  
require_once_dir( 'classes' ); 	#Incluye todos los .php de la carpeta classes (Clases necesarias propias de la app)
require_once_dir( 'controllers'); #Incluye todos los .php de la carpeta controlles (Controllers necesarios en la app)
require_once_dir( 'UsuarioControllers'); #Incluye todos los .php de la carpeta UsuarioControllers (Controllers que extienden de UsuarioController)

//LIBRERIAS - Incluyo las librerías necesarias ------------------------------------------------------------------------------		  

include('lib/xmlSimpleParser.php'); 	#Esta librería permite parsear url
include('lib/includeTwig.php');			#Uso de plantillas Twig

$twig->addGlobal('Estudio', new Estudio);
$twig->addGlobal('Profesion', new Profesion);
$twig->addGlobal('Mail', new Mail);
$twig->addGlobal('Telefono', new Telefono);
$twig->addGlobal('Categoria_Usuario', new Categoria_Usuario);
$twig->addGlobal('Tipo_Alta', new Tipo_Alta);
$twig->addGlobal('Rol', new Rol);
$twig->addGlobal('Usuario', new Usuario);
$twig->addGlobal('Clase', new Clase);
$twig->addGlobal('Naturaleza', new Naturaleza);
$twig->addGlobal('Procedencia', new Procedencia);
$twig->addGlobal('Forma_Contacto', new Forma_Contacto);
$twig->addGlobal('Usuario', new Usuario);
$twig->addGlobal('COOKIE', $_COOKIE);
$twig->addGlobal('CreateExcell', new CreateExcell);
$twig->addGlobal('categorias_archivos', CategoriasArchivosController::getAllCategories());
$twig->addGlobal('SESSION',$_SESSION);

require_once('dispatcher.php');
?>



