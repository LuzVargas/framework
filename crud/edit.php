<?php 
/**
 * @author  Luz Vargas luz.vt.89@gmail.com
 * @version  1.0
 * @package  crud
 * @copyright  2015
 *
 */
/**
 * @method  $_GET 
 * Método que sirve para editar a los usuarios.
 * @param   $usuarios es el usuario seleccionado
 * @param array $condition optiene el id seleccionado para editar
 * @param  $db edita al usuario en la base de datos llamando a find.
 */

include "../aplication/Database.php";

$conditions = array('conditions' => 'id='.$_GET['id']);

$usuario = $db->find('usuarios', 'first', $conditions);
?>

<h2>Editar usuario</h2>

<form action="proceso.php" method="POST">
	<input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">
	<input type="hidden" name="edit">
	<td>Email: <input type="email" name="email" value="<?php echo $usuario['email']; ?>"></td>
	<p>Username: <input type="text" name="username" value="<?php echo $usuario['username']; ?>"></p>
	<p>Password: <input type="password" name="password" value="<?php echo $usuario['password']; ?>"></p>
	<p>Status: <input type="number" name="status" value="<?php echo $usuario['status']; ?>"></p>
	<p><input type="submit"></p>

</form>