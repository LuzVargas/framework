<?php

/**
 * @author Luz Vargas
 * @category Modelo
 * @global Clase modelo para la ejecución de tareas
 * @package Models
 * @version 1.0
 */
class tareasModel extends AppModel
{

	/**
	 * Constructor de la clase tareasModel
	 * @return void
	 */
	public function __construct(){	
		parent::__construct();	
	}

	/**
	 * Obtiene todas las tareas
	 * @return string Devuelve una lista de tareas
	 */
	public function getTareas()
	{	
		$tareas = $this->_db->query("SELECT * FROM tareas");
		return $tareas->fetchall();
	
	}
}