<?
require_once("crudUtils/CrudInterface.class.php");

class Prato extends CrudInterface{
	public $_conecction_var = "cConexao";
	public $_table_name="tb_prato";
	public $_auto_increment_field="idPrato";
	public $_keys = "idPrato";
	
	public $idPrato;
	public $nome;
	public $descricao;
	public $origem;
	public $idRefeicaoFoto;
	public $idUsuario;
	public $dtCadastro;
	public $status;
}
?>