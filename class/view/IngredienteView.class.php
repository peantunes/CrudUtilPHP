<?
require_once("Template01View.class.php");
require_once("$__dirBase/class/crudUtils/CrudMenu.class.php");
class IngredienteView extends Template01View{
	protected $__template = "template_01";
	
	
	public function setPageInfo(){
		parent::setPageInfo();
		$this->setTitle('Pagina Ingrediente');
		$this->setMenu("contentMenu", $this->menuLocal(new CrudMenu("contentMenu")));
	}
	
	public function menuLocal($menu){
		$menu->setItem("Pesquisar", "/ingrediente/pesquisar/$1");
		$menu->setItem("Novo", "/ingrediente/editar/");
		return $menu;
	}
	
}
?>