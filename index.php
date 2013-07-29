<?php

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
require_once_dir( 'models/DB'); #Incluye Motor para conectar con Base de datos.
require_once_dir( 'models');  
require_once_dir( 'classes' ); 	#Incluye todos los .php de la carpeta classes (Clases necesarias propias de la app)
require_once_dir( 'controllers'); #Incluye todos los .php de la carpeta controlles (Controllers necesarios en la app)
require_once_dir( 'utils' );	#Incluye todos los .pnp de la carpeta utils -> utilidades varias (errores, logs, etc...)

//LIBRERIAS - Incluyo las librerías necesarias ------------------------------------------------------------------------------		  

include('lib/xmlSimpleParser.php'); 	#Esta librería permite parsear url
include('lib/includeTwig.php');			#Uso de plantillas Twig

require_once('dispatcher.php');
?>


