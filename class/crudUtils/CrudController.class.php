<?
require_once("CrudMessage.class.php");

abstract class CrudController{
	protected $__messages = array();
	protected $__view;
	protected $baseTemplate = "crudTemplate";
	
	/**
		Must be declared to return the view object
	*/
	abstract public function getView();
	
	/**
		Must be declared to define what is the first action.
	*/
	abstract public function begin();
	
	public function __constuct(){
		
	}
	
	private function useView(){
		if ($this->__view == null){
			$this->setView($this->getView());
		}
		return $this->__view;
	}
	
	public function setView($view){
		$this->__view = $view;
	}
	
	public function action($action){
		$view = $this->useView();
		$view->setPageContent("/page$action");
		return $view;
	}
	
	public function setParam($name,$par1){
		$view = $this->useView();
		$view->setParam($name,$par1);
	}
	
	public function getParam($name){
		$view = $this->useView();
		return $view->getParam($name);
	}
	
	public function getPars(){
		return $this->useView()->getPars();;
	}
	
	public function addMessage($msg){
		$this->useView()->addMessage($msg);
	}
	
	public function getMessages(){
		return $this->useView()->getMessages();
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
}
?>