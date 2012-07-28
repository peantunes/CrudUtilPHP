<?
require_once("$__dirBase/class/crudUtils/CrudModel.class.php");

class IngredienteModel extends CrudModel{
	public $_conecction_var = "cConexao";
	public $_table_name="tb_ingrediente";
	public $_auto_increment_field="idIngrediente";
	public $_keys = "idIngrediente";
	
	public $idIngrediente;
	public $nome;
	public $nomeAlternativo;
	public $descricao;
	public $idUsuario;
	public $idIngredienteRelacionado;
	public $dtCadastro;
	public $status;
}
?>