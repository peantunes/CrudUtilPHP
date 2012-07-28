<?
require_once("$__dirBase/class/view/AjaxView.class.php");
require_once("$__dirBase/class/model/LocalModel.class.php");
require_once("$__dirBase/class/controller/LocalController.class.php");

class MobileLocalController 
	extends LocalController{
	
	public function getView(){
		return new AjaxView();
	}

	public function begin(){
		return $this->pesquisar();
	}
	
	public function combo(){
		$loc = new LocalModel();
		
		$this->setParam("comboName", "local");
		$this->setParam("lista", $loc->find());
		
		return $this->action("/local/combo.php");
	}
	
	public function pesquisar($obj=null){
		$loc = new LocalModel();
		
		$this->setParam("lista", $loc->find());
		
		return $this->action("/local/lista.php");
	}
	
	public function editar($id=""){
		global $cConexao;
		
		$loc = new LocalModel();
		$this->setParam("local",$loc);
		if ($id > 0){
			$loc->setIdLocal($id);
			$item = $loc->find($loc);
			if (count($item)>0){
				$this->setParam("local",$item[0]);
			}else{
				$this->addMessage(new CrudMessage(CrudMessage::T_ERROR, "O id informado n�o foi encontrado."));
			}
		}
		
		return $this->action("/local/editar.php");
	}
	
	public function salvar($obj){
		global $cConexao;
		
		$loc = new LocalModel($this->getRequest());
		if ($loc->save()){
			$this->addMessage(new CrudMessage(CrudMessage::T_INFO, "Dados salvos"));
		}
		return $this->pesquisar();
	}
	
	public function excluir($id=""){
		global $cConexao;
		
		$loc = new LocalModel();
		$loc->setIdLocal($id);
		if ($loc->delete($loc)){
			$this->addMessage(new CrudMessage(CrudMessage::T_INFO, "Registro Exclu�do"));
		}
		return $this->pesquisar();
	}
}
?>