<?
require_once("$__dirBase/class/view/IngredienteView.class.php");
require_once("$__dirBase/class/model/IngredienteModel.class.php");
require_once("$__dirBase/class/crudUtils/CrudController.class.php");

class IngredienteController 
	extends CrudController{
	
	public function getView(){
		return new IngredienteView();
	}

	public function begin(){
		return $this->pesquisar();
	}
	
	public function pesquisar($obj=null){
		global $cConexao;
		
		$loc = new IngredienteModel();
		
		$this->setParam("lista", $loc->find());
		
		return $this->action("/ingrediente/lista.php");
	}
	
	public function editar($id=""){
		global $cConexao;
		
		$loc = new IngredienteModel();
		$this->setParam("ingrediente",$loc);
		if ($id > 0){
			$loc->setIdIngrediente($id);
			$item = $loc->find($loc);
			if (count($item)>0){
				$this->setParam("ingrediente",$item[0]);
			}else{
				$this->addMessage(new CrudMessage(CrudMessage::T_ERROR, "O id informado não foi encontrado."));
			}
		}
		
		return $this->action("/ingrediente/editar.php");
	}
	
	public function excluir($id=""){
		global $cConexao;
		
		$loc = new IngredienteModel();
		$loc->setIdIngrediente($id);
		if ($loc->delete($loc)){
			$this->addMessage(new CrudMessage(CrudMessage::T_INFO, "Registro excluído"));
		}
		return $this->pesquisar();
	}
	
	public function salvar($obj){
		global $cConexao;
		
		$loc = new IngredienteModel($this->getRequest());
		if ($loc->save()){
			$this->addMessage(new CrudMessage(CrudMessage::T_INFO, "Dados salvos"));
		}
		return $this->pesquisar();
	}
}
?>