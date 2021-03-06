<?php

//print_r($_GET['url']); // sirve para listar

/**
 * @author  Luz Vargas luz.vt.89@gmail.com
 * @version  1.0
 * @package  Framework
 * @copyright 2015
 */
//Framework Básico de Modelo,Vista,Controlador

/*
/lunux
\windows
*/

define("DS", DIRECTORY_SEPARATOR);
define("ROOT", realpath(dirname(__FILE__)).DS);
define("APP_PATH", ROOT. "aplication".DS);

//echo ROOT; //imprime la ruta del proyecto
require_once(APP_PATH. "Config.php");
require_once(APP_PATH. "Request.php");
require_once(APP_PATH. "Bootstrap.php");
require_once(APP_PATH. "Controller.php");
require_once(APP_PATH. "Model.php");
require_once(APP_PATH. "View.php");
require_once(APP_PATH. "Database.php");
require_once(APP_PATH. "Autoload.php");

//Comprobar que los archivos se estan cargando correctamente
//echo "<pre>";print_r(get_required_files());

try{
	Bootstrap::run(new Request);
}catch(Exception $e){
	echo $e->getMessage();
}



