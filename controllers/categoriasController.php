<?php
/**
 * @author  Luz Vargas luz.vt.89@gmail.com
 * @version  1.0
 * @package  categoriasController
 * @category  Controlador
*/

class Categorias extends AppController
{
	/**
	*Método constructor
	* @return  void
	*/
	public function __construct()
	{
		parent::__construct();
	}

	/**
	*Método index
	* @return  void
	*/

	public function index(){
		$categorias = $this->db->find("categorias", "all");
		$this->set("categorias", $categorias);
	}

	/**
	*Método agregar
	* @return  void
	*/
	public function add(){
		if($_POST){
			if($this->db->save("categorias", $_POST)){
				$this->redirect(array("controller"=>"categorias"));
			}else{
				$this->redirect(array(
					"controller"=>"categorias","action"=>"add")
				);
			}
		}else{
			$this->_view->titulo = "Agregar categorias";
			$this->_view->renderizar('add');	
		}
	}

	/**
	*Método editar
	* @return  void
	*/
	public function edit($id = null){
		if($_POST)
		{
			if($this->db->update('categorias', $_POST)){
				$this->redirect(array('controller' => 'categorias', 'action' => 'index'));
			}else{
				$this->redirect(array('controller' => 'categorias', 'action' => 'edit/'.$_POST['id']));
			}
		}else{
			$this->_view->titulo = "Editar categoria";
			$this->_view->categoria = $this->db->find('categorias', 'first', array('conditions' => 'id='.$id));
			$this->_view->renderizar('edit');
		}
	}

	/**
	*Método eliminar
	* @return  void
	*/
	public function delete($id = null){
		$condition = 'id='.$id;
		if($this->db->delete('categorias', $condition)){
			$this->redirect(array('controller' => 'categorias', 'action' => 'index'));
		}
	}
} 