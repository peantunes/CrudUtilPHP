<?
class CrudMenu{
	public $value;
	private $__item = array();
	
	public function __constuct($val = null){
		$this->value = $val;
	}
	
	public function setItem($name, $item){
		$this->__item[$name] = $item;
	}
	
	public function printMenu($pattern="<li>#menuItem</li>"){
		$keys = array_keys($this->__item);
		foreach ($keys as $key){
			$this->printItem($key, $this->__item[$key], $pattern);
		}
	}
	
	public function printItem($key, $value, $pattern){
		$ret = "<a href=\"?__action=$value\">$key</a>";
		echo str_replace("#menuItem",$ret,$pattern);
	}
}
?>