<?
require_once("$__dirBase/class/crudUtils/CrudModel.class.php");

class LocalModel extends CrudModel{
	protected $_conecction_var = "cConexao";
	protected $_table_name="tb_local";
	protected $_auto_increment_field="idLocal";
	protected $_keys = "idLocal";
	
	public $idLocal;
	public $nome;
	public $descricao;
	public $latitude;
	public $longitude;
	public $cidade;
	public $pais;
	public $dtCadastro;
	public $idUsuarioCadastro;
	public $tipo;
	public $status;
}
?>