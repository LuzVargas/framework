<?php 

/**
 * @author  Luz Vargas luz.vt.89@gmail.com
 * @version  1.0
 * @package  crud
 * @copyright  2015
 *
 */

include "../aplication/Database.php";

/**
 * @method  $_POST 
 * Método que sirve para agregar usuarios.
 * @param  $db agrega al usuario en la base de datos llamando a save.
 * @author  Luz Vargas luz.vt.89@gmail.com
 */

	if($_POST){
		if(isset($_POST['add'])){
			if($db->save("usuarios", $_POST)){
			echo "Datos guardados Correctamente";
		}else{
			echo "Error al guardar los datos";
		}
/**
 * @method  $_POST 
 * Método que sirve para editar usuarios.
 * @param  $db edita al usuario en la base de datos llamando a update.
 * @author  Luz Vargas luz.vt.89@gmail.com
 */
	}elseif (isset($_POST['edit'])) {
		if($db->update("usuarios", $_POST)){
			echo "Datos actualizados Correctamente";
		}else{
			echo "Error al actualizar los datos";
		}
	}
}

/**
 * @method  $_GET 
 * Método que sirve para eliminar a los usuarios.
 * @param  $condition opteniendo el id seleccionado para eliminar
 * @param  $db elimina al usuario en la base de datos llamando a delete.
 * @author  Luz Vargas luz.vt.89@gmail.com
 */
if(isset($_GET['del']))
{
	$condition = "id=".$_GET['id'];
	echo ($db->delete("usuarios", $condition)) ? 
	"Datos eliminados correctamente." : "Error al eliminar los datos" ;
}
