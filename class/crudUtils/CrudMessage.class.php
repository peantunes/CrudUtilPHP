<?
class CrudMessage{
	const T_INFO = 0;
	const T_WARNING = 0;
	const T_ERROR = 0;
	
	private $__type;
	private $__message;
	private $__code;
	
	public function __construct($type, $message, $code=0){
		$this->__type = $type;
		$this->__message = $message;
		$this->__code = $code;
	}
		
	public function getMessage(){
		return $this->__message;
	}
		
	public function getCode(){
		return $this->__code;
	}
		
	public function getType(){
		return $this->__type;
	}
		
	public function setMessage($val){
		$this->__message = $val;
	}
		
	public function setCode($val){
		$this->__code = $val;
	}
		
	public function setType($val){
		$this->__type = $val;
	}
}

?>