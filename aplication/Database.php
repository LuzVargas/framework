<?php
/**
 *Archivo de clase de conexión PDO 
 * 
 * Clase que peermite acciones Crud usando PDO
 * 
 * @package  PDO
 * @author  Luz Elena Vargas Tec <luz.vt.89@gmail.com>
 * @version  1.0
 * 
 */

class classPDO{
	public $connection;
	private $dns;
	private $drive;
	private $host;
	private $database;
	private $username;
	private $password;
	public $result;
	public $lastInsertId;
	public $numberRows;

	/**
	 *Constructor de la clase 
	 * 
	 * @return  void
	 */

	public function __construct($drive = 'mysql',$host = 'localhost',$database = 'gestion',
		$username = 'root',$password = ''){

		$this->drive = $drive;
		$this->host = $host;
		$this->database = $database;
		$this->username = $username;
		$this->password = $password;
		$this->connection();
		}

		/**
		 * Método de conexión a la base de datos.
		 * 
		 * Método que permite establecer una conexión a la Base de Datos.
		 * 
		 * @return  void
		 */

		private function connection(){
			$this->dns = $this->drive.':host='.$this->host.';dbname='. $this->database;

			try{
				$this->connection = new PDO(
					$this->dns,
					$this->username,
					$this->password
				);
				$this->connection->setAttribute(
					PDO::ATTR_ERRMODE,
					PDO::ERRMODE_EXCEPTION
				);
			}catch(PDOException $e){
				echo "Error: ".$e->getMessage();
				die();
			}
		}

		/**
		 * @method  find
		 * 
		 * Método que sirve para hacer consultas a la Base de Datos.
		 * 
		 * @param string $table nombre de la tabla a consultar.
		 * @param  string $query tipo de consulta.
		 * -all
		 * -first
		 * -count
		 * @param  array $options restricciones en la consulta.
		 * -fields
		 * -conditions
		 * -group
		 * -order
		 * -limit
		 * @return  object
		 * 
		 */

		public function find($table = null,$query=null, $options = array()){

			$fields = '*';

			$parameters ='';

			if (!empty($options['fields'])){
				$fields = $options['fields'];
			}

			if (!empty($options['conditions'])){
				$parameters = 'WHERE '.$options['conditions'];
			}
			if (!empty($options['group'])){
				$parameters = 'GROUP BY '.$options['group'];
			}
			if (!empty($options['order'])){
				$parameters = 'ORDER BY '.$options['order'];
			}
			if (!empty($options['limit'])){
				$parameters = 'LIMIT '.$options['limit'];
			}

			
			switch ($query) {
				case 'all':
					$sql ="SELECT $fields FROM $table".' '.$parameters;
					$this->result =$this->connection->query($sql);
				break;
				case 'count':
					$sql ="SELECT COUNT(*) FROM $table".' '.$parameters;
					$result = $this->connection->query($sql);
					$this->result = $result->fetchColumn();
				break;
				
				case 'first':
					$sql ="SELECT $fields FROM $table".' '.$parameters;
					$result = $this->connection->query($sql);
					$this->result = $result->fetch();
				break;
					
				default:
					$sql ="SELECT $fields FROM $table".' '.$parameters;
					$this->result = $this->connection->query($sql);
				break;
			}
			return $this->result;

		}

		/**
		 *@method  save
		 * 
		 * Método que sirve para guardar registros
		 * 
		 * @param  string $table tabla a consultar.
		 * @param  array $data valores a guardar.
		 * @return  object
		 * @author  Luz Vargas luz.vt.89@gmail.com 
		 */

		public function save($table = null, $data = array()){
			$sql = "SELECT * FROM $table";
			$result = $this->connection->query($sql);

			for ($i=0; $i < $result->columnCount(); $i++) { 
				$meta=$result->getColumnMeta($i);
				$fields[$meta['name']] = null;
			}

			$fieldsToSave = 'id';
			$valueToSave = 'NULL';

			foreach ($data as $key => $value) {
				if (array_key_exists($key, $fields)) {
					$fieldsToSave .=', '.$key;
					$valueToSave .= ', '."\"$value\"";
				}
			}

			$sql = "INSERT INTO $table ($fieldsToSave)
			VALUES($valueToSave)";

			#echo $sql;
			#exit;

			$this->result = $this->connection->query($sql);

			return $this->result;
		}

		/**
		 * @method  update
		 * 
		 * Método que sirve para actualizar registros.
		 * 
		 * @param  string $table tabla a consultar
		 * @param  array $data valores a actualizar
		 * @return  object
		 * @author  Luz Vargas luz.vt.89@gmail.com
		 */

		public function update($table = null, $data = array()){
			$sql = "SELECT * FROM $table";
			$result = $this->connection->query($sql);

			for ($i=0; $i < $result->columnCount(); $i++) { 
				$meta=$result->getColumnMeta($i);
				$fields[$meta['name']] = null;
			}

			if (array_key_exists("id", $data)){
				$fieldsToSave = "";
				$id = $data["id"];
				unset($data["id"]);

				$i = 0;
				foreach ($data as $key => $value) {
					if (array_key_exists($key, $fields)) {
						$fieldsToSave .=$key."="."\"$value\", ";
					}
				}
				$fieldsToSave = substr_replace($fieldsToSave, '', -2);

				$sql = "UPDATE $table SET $fieldsToSave WHERE $table.id=$id;";
				#echo $sql;
				#exit;
			}
			$this->result = $this->connection->query($sql);

			return $this->result;
		}

		/**
		 *@method   delete
		 * 
		 * Método que sirve para eliminar registros.
		 * 
		 * @param  string $table tabla a consultar
		 * @param  string $condition condición a cumplir
		 * @return  object
		 * @author  Luz Vargas luz.vt.89@gmail.com 
		 */

		public function delete($table = null, $condition = null){
			
			$sql = "DELETE FROM $table WHERE $condition".";";
			$this->result = $this->connection->query($sql);
			$this->numberRows = $this->result->rowCount();

			return $this->result;
		}
	}

	$db = new classPDO();


