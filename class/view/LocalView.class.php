<?
require_once("Template01View.class.php");
require_once("$__dirBase/class/crudUtils/CrudMenu.class.php");
class LocalView extends Template01View{
	protected $__template = "template_01";
	
	
	public function setPageInfo(){
		parent::setPageInfo();
		$this->setTitle('Pagina teste - #page');
		$this->setMenu("contentMenu", $this->menuLocal(new CrudMenu("contentMenu")));
	}
	
	public function menuLocal($menu){
		$menu->setItem("Pesquisar", "/local/pesquisar/$1");
		$menu->setItem("Novo", "/local/editar/");
		return $menu;
	}
	
}
?>