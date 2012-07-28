<?
require_once("CrudTypes.class.php");

class CrudType{
	const T_STRING = "STRING";
	public $value;
	
	public function __constuct($val = null){
		$this->value = $val;
	}
	public function __toString(){
		return $this->value;
	}
	
	public static function newInstance(){
		return new self;
	}
}
class CrudString extends CrudType{
}
class CrudText extends CrudType{
}
class CrudDouble extends CrudType{
}
class CrudInteger extends CrudType{
}
class CrudDate extends CrudType{
}
?>