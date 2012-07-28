<?
require_once("CrudTypes.class.php");

class CrudLog{
	const T_INFO = 1;
	const T_ERROR = 2;
	
	private $logType = CrudLog::T_ERROR;
	
	public function __construct($logType){
		$this->logType = $logType;
	}
	
	public function info($text){
		if ($this->logType <= CrudLog::T_INFO){
			echo $text;
		}
	}
	
	public function error($text){
		if ($this->logType <= CrudLog::T_ERROR){
			echo $text;
		}
		
	}
}
?>