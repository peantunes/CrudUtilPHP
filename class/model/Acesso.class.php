<?
require_once("crudUtils/CrudInterface.class.php");

class Acesso extends CrudInterface{
	public $_conecction_var = "cConexao";
	public $_table_name="tb_acesso";
	public $_auto_increment_field="idAcesso";
	public $_keys = "idAcesso";
	
	public $idAcesso;
	public $idUsuario;
	public $tipo;
	public $equipamento;
	public $dtAcesso;
	public $latitude;
	public $longitude;
}
?>