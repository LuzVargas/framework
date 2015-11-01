<?php

abstract class AppController{

	protected $_view;
	protected $db;

	public function __construct(){
		$this->_view = new View(new Request);
		$this->db = new ClassPDO();
	}

	abstract public function index();

	protected function redirect($url = array()){
		$path = "";
		if ($url["controller"]){
			$path .= $url["controller"];
		}
		if ($url["action"]){
			$path .= "/".$url["action"];
		}
		header("Location: ".APP_URL.$path);
	}

}
