<?
require_once("$__dirBase/class/crudUtils/CrudView.class.php");
class Template01View extends CrudView{
	protected $templateFile = "template_01";
	public $title;
	
	
	public function setPageInfo(){
		$this->setTitle('Pagina teste - #page');
		$this->setHeadHeader("page/inc/head.php");
		$this->setPageFooter("page/inc/footer.php");
		$this->setPageHeader("page/inc/header.php");
		$this->setMenu("topMenu",$this->menuTop(new CrudMenu("topMenu")));
	}
	
	public function menuTop($menu){
		$menu->setItem("Local", "local");
		$menu->setItem("Ingrediente", "ingrediente");
		return $menu;
	}
}
?>