<?php
/**
 *  Manejo de CRUD sobre usuarios
 */

/**
 *@author  Luz Vargas luz.vt.89@gmail.com
 * @version  1.0
 * @package  crud
 * @copyright  2015 
 */

include "../aplication/Database.php";

/**
 * @param  array $option  se especifica que campos se muestran
 * el límite de cantidad y de que forma se muestran, ascendente o descendente. 
 */

$option = array(
	'fields'=>'id, email, username, password, status',
	'limit'=>'0,6',
	'order'=>'usuarios.id ASC'
	);

$usuarios = $db->find('usuarios', 'all', $option);

$numeroUsuarios = $db->find('usuarios', 'count', null);

echo "<h4>Numero de usuarios:  </h4>".$numeroUsuarios;
?>
<p>
<a href="add.php?id=<?php echo $usuario['id'];?>">Agregar Usuario</a>
</p>

<table border="1">

	<tr>
		<td>ID</td>
		<td>Email</td>
		<td>Username</td>
		<td>Password</td>
		<td>Status</td>
		<td>Accion</td>
	</tr>
<?php foreach ($usuarios as $usuario):  ?>
	

	<tr>
		<td> <?php echo $usuario['id']; ?></td>
		<td> <?php echo $usuario['email']; ?></td>
		<td> <?php echo $usuario['username']; ?></td>
		<td> <?php echo $usuario['password']; ?></td>
		<td> <?php echo $usuario['status']; ?></td>
		<td>
			<a href="edit.php?id=<?php echo $usuario['id'];?>">Editar</a>|  
			<a href="proceso.php?del&id=<?php echo $usuario['id'];?>">Eliminar</td></a> 
		

	</tr>

<?php endforeach; ?>
</table>