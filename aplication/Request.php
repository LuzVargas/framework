<?php
/**
 * @author  Luz Elena Vargas luz.vt.89@gmail.com 
 * @version  1.0
 * @package  aplication
 * @copyright  2015
 * 
 */

class Request{
	private $_controlador;
	private $_metodo;
	private $_argumentos;

public function __construct(){
		if (isset($_GET['url'])) {
			$url = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL);
			$url = explode("/", $url);
			$url = array_filter($url);
		
			$this->_controlador = strtolower(array_shift($url));
			$this->_metodo = strtolower(array_shift($url));
			$this->_argumentos = $url;
		}

		if (!$this->_controlador) {
			 $this->_controlador = DEFAULT_CONTROLLER;
		}
		if (!$this->_metodo) {
			 $this->_metodo = "index";
		}
		if (!isset($this->_argumentos)) {
			 $this->_argumentos = array();
		}
	}

	/**
	 *getControlador metodo que permite obtener el valor del controlador 
	 *@return  string valor del metodo
	 */
	public function getControlador(){
		return $this->_controlador;
	}

	/**
	 * getMetodo metodo que permite obtener el metodo
	 * @static string valor del metodo
	 */
	public function getMetodo(){
		return $this->_metodo;
	}

	/**
	 * getArgs meetodo que permite obtener los valores de los argumentos
	 * @return  array valor de los argumentos
	 */
	public function getArgs(){
		return $this->_argumentos;
	}

}