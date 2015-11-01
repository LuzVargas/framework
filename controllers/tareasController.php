<?php

class tareasController extends AppController
{
	
	public function __construct(){
		parent::__construct();
	}

	public function index(){
		//Se envia un mensaje de prueba
		//echo "Hola desde el metodo Index";
		$this->_view->titulo = "Pagina principal";
		$this->_view->tareas = $this->db->find('tareas', 'all', null);
		$this->_view->renderizar('index');
	
	}
	public function add(){
		if ($_POST) {
			if ($this->db->save('tareas', $_POST)){
				$this->redirect(array('controller'=>'tareas'));
			}else{
				$this->redirect(
					array(
						'controller'=>'tareas','action'=>'add'));
			}
		}else{
			$this->_view->titulo = "Agregar tarea";
		}
		
		$this->_view->renderizar('add');
	}

	public function edit($id = null){
		if ($_POST){
			if ($this->db->update('tareas', $_POST)){
				$this->redirect(
					array(
						'controller'=>'tareas',
						'action'=>'index'
					)
				);
		}else{
			$this->redirect(
				array(
					'controller'=>'tareas',
					'action'=>'edit/'.$_POST['id']
				)
			);
		}
	}else{
		$this->_view->titulo ="Editar tareas";
		$this->_view->tarea = $this->db->find('tareas', 'first',
			array(
				'conditions'=>'id='.$id
				)
			);
			$this->_view->renderizar('edit');
		}
	}
	public function delete($id = null){
		$conditions = 'id='.$id;
		if ($this->db->delete('tareas', $conditions)){
			$this->redirect(
				array(
					'controller'=>'tareas','action'=>'index'
				)
			);

		}
	}
}
