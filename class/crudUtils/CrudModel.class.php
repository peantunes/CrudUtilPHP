<?
require_once("CrudTypes.class.php");
require_once("CrudLog.class.php");

class CrudModel{
	protected $_connection_var="cConexao";
	protected $_table_name=null;
	protected $_auto_increment_field=null;
	
	const INT_STATUS_DELETED = 3;
	const INT_STATUS_SAVED = 2;
	const INT_STATUS_LOAD = 1;
	const INT_STATUS_NEW = 0;
	
	private $_status = 0;
	
	/**
		The Constructor receive the RecordSet to set the values to the object
	**/
	function __construct($rs = ""){
		$this->_log = new CrudLog(CrudLog::T_ERROR);
		if ($rs != ""){
			$this->setRs($rs);
		}
	}
	
	public function setRs($rs){
		$obj1 = $this->getColsAndValues($this, true);
		$keys = $obj1["cols"];
		$countKeys = count($keys);
		for($i=0;$i<$countKeys;$i++){
			$key = $keys[$i];
			$lkey = strtolower($key);
			if (array_key_exists($lkey,$rs)){
				$this->$key = $rs[$lkey];
			}
		}
	}
	
	/**
	 That method emulate the get/set methods from the class
	*/
	public function __call($name, $arguments){
		
		try{
			$novoname = strtolower(substr($name,3,1)).substr($name,4,strlen($name)-4);
			if (strpos($name,"get")===0){
				return $this->$novoname;
			}else if (strpos($name,"set")===0){
				if (count($arguments)>0){
					$this->$novoname = $arguments[0];
				}
			}
			
		}catch (Exception $e){
		}
	}
	
	/**
	 Add a new record to database. This method ignore if the record was load from database.
	*/
	public function add(){
		$conn = $GLOBALS[$this->_connection_var];
		$obj = $this->getColsAndValues();
		$values = $obj["vals"];
		$cols = $obj["cols"];
		$sql = "insert into ".$this->_table_name."(".implode(",",$cols).")"
			." values('".implode("','",$values)."')";
		$this->_log->info($sql);
		$conn->Executa($sql);
		//Add the Id to AutoIncrementField
		if ($this->_auto_increment_field != null){
			$autoincrement = $this->_auto_increment_field;
			$this->$autoincrement = $conn->getId();
		}
		return true;
	}

	/**
	 Save the current information into database.
	 If the record was loaded and had the key values is updated.
	 If hadn't the keys the record is inserted.
	*/
	public function save(){
		$conn = $GLOBALS[$this->_connection_var];
		$obj = $this->getColsAndValues();
		$vals = $obj["vals"];
		$cols = $obj["cols"];
		//Verificar as chaves
		if (!$this->hasKeys($cols,$vals)){
			return $this->add();
		}else{
			$sets = array();
			$where = array();
			$sql = "update {$this->_table_name} set ";
			for ($i=0;$i<count($cols);$i++){
				if (strpos($this->_keys,$cols[$i])!==false){
					array_push($where, strtolower($cols[$i])."='".$vals[$i]."'");
				}else{
					array_push($sets, strtolower($cols[$i])."='".$vals[$i]."'");
				}
			}
			$sql .= implode(",",$sets);
			$sql .= " where ".implode(" \n AND ",$where);
			$this->_log->info($sql);
			$conn->Executa($sql);
			
			return true;
		}
		//
	}
	
	/** 
		Delete the current record from database.
		Only if are the key values
	*/
	public function delete(){
		$conn = $GLOBALS[$this->_connection_var];
		$where = array();
		$obj = $this->getColsAndValues();
		$vals = $obj["vals"];
		$cols = $obj["cols"];
		//Verificar as chaves
		if ($this->hasKeys($cols,$vals)){
			for ($i=0;$i<count($cols);$i++){
				if (strpos($this->_keys,$cols[$i])!==false){
					array_push($where, strtolower($cols[$i])."='".$vals[$i]."'");
				}
			}
			
			$sql = "delete from ".$this->_table_name;
			$sql .= " where ".implode(" \n and ",$where);
			$conn->Executa($sql);
			$this->_log->info($sql);
			return true;
		}else{
			return false;
		}
	}
	
	/**
		With a object the method fill the search with the parameters.
	**/
	public function find($obj=null,$rows="",$page=1){
	
		$conn = $GLOBALS[$this->_connection_var];
		$i=0;
		if ($obj != null){
			$obj = $this->getColsAndValues($obj);
			$vals = $obj["vals"];
			$cols = $obj["cols"];
			$where = array();
			for ($i=0;$i<count($cols);$i++){
				array_push($where, strtolower($cols[$i])."='".$vals[$i]."'");
			}
		}
		$sql = "select * from ".$this->_table_name;
		if ($i>0){
			 $sql .= " where ".implode(" \n and ",$where);
		}
		if ($rows != ""){
			$start = $page*$rows + 1;
			$sql .= " limit $start, $rows";
		}
		$this->_log->info($sql);
		$conn->Executa($sql);
		$list = array();
		$class1 = get_class($this);
		while ($conn->Linha()){
			$newObj = new $class1;
			$newObj->setRs($conn->rs);
			array_push($list, $newObj);
		}
		
		return $list;
		
	}
	
	public function toString(){
		$list = get_class_vars(get_class($this));
		foreach ($list as $name => $value) {
			$this->_log->info("$name : ".$this->$name."\n");
		}
	}
	
	private function hasKeys($cols, $values){
		
		$keys = $this->_keys;
		$key=0;
		for ($i=0;$i<count($cols);$i++){
			if (strpos($keys,$cols[$i])!==false){
				$key++;
			}
		}
		return $key==count($keys);
	}
	
	
	private function getColsAndValues($obj="", $blankValues=false){
		if($obj == ""){
			$obj = $this;
		}
		$list = get_class_vars(get_class($obj));
		$cols = array();
		$values = array();
		
		foreach ($list as $name => $value) {
			if ($name[0] != "_"){
				if ($blankValues || $obj->$name != null){
					array_push($cols, $name);
					array_push($values,$obj->$name);
				}
			}
		}
		
		return array("cols" => $cols, "vals" => $values);
	}
	
}
?>