<?php
/**
 * @author  Luz Vargas luz.vt.89@gmail.com
 * @version  1.0
 * @package  crud
 * @copyright  2015
 *
 */
/**
 * @method  $POST 
 * Método que sirve para agregar a un usuario.
 * @param   $usuario es el usuario que se agrgara con su respectibo id
 * Plantilla para agregar los campos especificos de un nuevo usuario
 */
?>
<h2>Agregar usuario</h2>
<form action="proceso.php" method="POST">

	<input type="hidden" name="add" value="<?php echo $usuario['id']; ?>">
	<p>Email: <input type="email" name="email"></p>
	<p>Username: <input type="text" name="username"></p>
	<p>Password: <input type="password" name="password"></p>
	<p>status: <input type="number" name="status"></p>
	<p><input type="submit" value="Enviar"></p>

</form>
