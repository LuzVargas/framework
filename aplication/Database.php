<?php

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

	public function __construct(
		$drive = 'mysql',
		$host = 'localhost',
		$database = 'gestion',
		$username = 'root',
		$password = ''){

		$this->drive = $drive;
		$this->host = $host;
		$this->database = $database;
		$this->username = $username;
		$this->password = $password;
		$this->connection();
		}

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

		public function delete($table = null, $condition = null){
			
			$sql = "DELETE FROM $table WHERE $condition".";";
			$this->result = $this->connection->query($sql);
			$this->numberRows = $this->result->rowCount();

			return $this->result;
		}
	}

	$db = new classPDO();


