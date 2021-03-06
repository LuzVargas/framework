<?php

/**
 * clase usuariosController
 * @author  Luz Vargas luz.vt.89@gmail.com
 * @version  1.0
 * @package  controllers
 * @copyright  2015
 *
 */
class usuariosController extends AppController
{
	
	private $pass;
	public function __construct(){
		parent::__construct();
	}
/**
 * Método Index
 * @author  Luz Vargas luz.vt.89@gmail.com 
 */
	public function index(){		
		$this->_view->titulo = "Usuarios";
		$this->_view->usuarios =$this->db->find('usuarios','all');
		$this->_view->renderizar('index');		
	}
/**
 * 	 
 * Metodo save 
 * Metodo que sirve para guardar usuarios
 * 
 * @author  Luz Vargas luz.vt.89@gmail.com
 *
 */
	public function add(){
		if ($_POST){
			$pass = new Password();
			$_POST['password'] = $pass->getPassword($_POST['password']);

			if ($this->db->save("usuarios", $_POST)) {
				$this->redirect(array('controller'=>'usuarios', 'action'=>'index'));
			}else{
				$this->redirect(array('controller'=>'usuarios', 'action'=>'add'));
			}
		}else{
			$this->_view->titulo = "Agregar usuario";
			$this->_view->renderizar('add');
		}	
	}

/**
 * 	 
 * Metodo update  
 * Metodo que sirve para actualizar usuarios
 * 
 * @author  Luz Vargas luz.vt.89@gmail.com
 *
 */
	public function edit($id = null){
		if ($_POST){
			if (!empty($_POST['pass'])) {
				$pass = new Password();
				$_POST['password'] = $this->pass->getPassword($_POST['password']);
			}
			if ($this->db->update('usuarios', $_POST)) 
			{
				$this->redirect(array('controller'=>'usuarios', 'action'=>'index'));
			}else{
				$this->redirect(array('controller'=>'usuarios', 'action'=>'edit/'.$_POST['id']));
			}
		}else{
			$this->_view->titulo = "Editar usuario";
			$this->_view->usuario = $this->db->find('usuarios', 'first', array('conditions'=>'id='.$id));
			$this->_view->renderizar('edit');
		}	
		
	}
	
/**
 * 	 
 * Metodo delete   
 * Metodo que sirve para eliminar  usuarios
 * 
 * @author  Luz Vargas luz.vt.89@gmail.com
 *
 */
	public function delete($id = null){
		$condition = 'id='.$id;
		if ($this->db->delete('usuarios', $condition)) {
			$this->redirect(
					array('controller'=>'usuarios','action'=>'index')	
			);
		}
	}

	/**
	 * Método Iniciar sesión
	 * 
	 * Método que permite que el usuario inicie sesión en el sistema
	 * @param  $options array con los datos del usuario
	 * @return  renderizar 
	 */
	public function login(){
		if ($_POST){
			$pass = new Password();
			$filter = new Validations();
			$auth = new Authorization();

			$username = $filter->sanitizeText($_POST['username']);
			$password = $filter->sanitizeText($_POST['password']);

			$options ['conditions'] = "username='$username'";
			$usuario = $this->db->find('usuarios','first',$options);

			if ($pass->isValid($password, $usuario['password'])){
				$auth->login($usuario);
				$this->redirect(array('controller'=>'tareas'));
			}else{
				echo "usuario invalido";
			}
			
		}
		$this->_view->renderizar('login');
	}

	/**
 	* @method logout
 	* Método logout
 	* 
 	* Método que termina la sesión del usuario
 	* 
 	*/
	public function logout(){
		$auth = new Authorization();
		$auth->logout();
	}
}