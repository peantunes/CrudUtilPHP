<?
require_once("CrudUtil.class.php");
abstract class CrudView{
	private $__param = array();
	private $__messages = array();
	public $__menu = array();
	private $__pageContent;
	private $pageFooter;
	private $pageHeader;
	private $headMeta;
	
	abstract public function setPageInfo();
	
	public function __construct(){
		$this->setPageInfo();
	}
	
	public static function newInstance(){
		return new self;
	}
	
	public function setPageContent($pageContent){
		$this->__pageContent = $pageContent;
	}
	
	public function getPageContent(){
		return $this->__pageContent;
	}
	
	/**
		Page Content
	*/
	public function pageContent(){
		$this->openPage($this->__pageContent);
	}
	
	/**
		Page Header
	*/
	public function pageHeader(){
		$this->openPage($this->pageHeader);
	}
	
	/**
		Page Footer
	*/
	public function pageFooter(){
		$this->openPage($this->pageFooter);
	}

	/**
		Header Meta
	*/
	public function headMeta(){
		$this->openPage($this->headMeta);
	}
	
	public function openPage($page){
		global $_REQUEST, $_POST, $_GET, $_SERVER;
		$CrudView = $this;
		if (isset($page)){
			include($page);
		}
	}
	
	public function openTemplateFileURL(){
		$this->openPage("page/template/$this->templateFile.php");
	}
	
	public function getPars(){
		return $this->__param;
	}
	
	public function getParam($name){
		if (array_key_exists($name,$this->__param)){
			return $this->__param[$name];
		}
		return null;
	}
	
	public function setParam($name, $value){
		$this->__param[$name] = $value;
	}
	
	public function addMessage($msg){
		array_push($this->__messages,$msg);
	}
	
	public function getMessages(){
		return $this->__messages;
	}
	
	public function setMenu($name, $menu){
		$this->__menu[$name] = $menu;
	}
	
	public function pageMenu($name, $pattern="<li>#menuItem</li>"){
		$this->__menu[$name]->printMenu($pattern);
	}
	
	public function getServer(){
		global $_SERVER;
		return $_SERVER;
	}
	
	public function getRequest(){
		global $_REQUEST;
		return $_REQUEST;
	}
	
	public function getGet(){
		global $_GET;
		return $_GET;
	}
	
	public function getPost(){
		global $_POST;
		return $_POST;
	}
	/**
	 That method emulate the get/set methods from the class
	*/
	public function __call($name, $arguments){
		
		try{
			if(method_exists($this, $name)) { 
				return call_user_func_array(array($this, $name), $arguments); 
			}
			$newname = strtolower(substr($name,3,1)).substr($name,4,strlen($name)-4);
			if (strpos($name,"get")===0){
				return $this->$newname;
			}else if (strpos($name,"set")===0){
				if (count($arguments)>0){
					$this->$newname = $arguments[0];
				}
			}
			
		}catch (Exception $e){
		}
	}
}
?>