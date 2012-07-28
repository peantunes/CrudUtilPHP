<?php

define("INT_SQLSERVER", "1");
define("INT_ORACLE", "2");
define("INT_POSTGRE", "3");
define("INT_MYSQL", "4");
	
class Conexao {
	var $intBanco; 	 // Indica o tipo de banco que ser· utilizado
	var $strBanco; 	 // Indica o nome do banco ou host
	var $strUsuario; // Indica o usu·rio que conectar· ao banco
	var $strSenha;	 // Indica a senha do Usu·rio que conecta ao banco
	var $strBase;	 // Indica a base do banco que ser· utilizada
	var $strConexao; // Indica a string de conex„o com o banco (utilizado pelo Oracle)

	var $conexao;	 // ContÈm a Conex„o aberta
	var $cursor;	 // Cursor
	var $parse;		 // Parse (somente Oracle)
	var	$rs;		 // Linha do recordset
	var $cErro;		 // classe que contem os erros de execuÁ„o da classe
	
	
	
	
	//Inicializa indicando o tipo de Banco
	 function Conexao($intBanco1, $strBanco1, $strUsuario1, $strSenha1, $strBase1, $strConexao1=""){
		//Instancia a classe de Erros
		//$this->erro = new Erro(0);
		
		//Recebe os parametros
		$this->intBanco = $intBanco1;
		$this->strBanco = $strBanco1;
		$this->strUsuario = $strUsuario1;
		$this->strSenha = $strSenha1;
		$this->strBase = $strBase1;
		$this->strConexao = $strConexao1;
		
	}
	
	
	//Inicia uma transaÁ„o
	 function BeginTrans(){
		switch ($this->intBanco){
			case INT_SQLSERVER:
				$this->Executa("begin");
				break;
			case INT_ORACLE:
				/*$this->parse = ociparse($this->conexao, $strSQL) or die;
				$this->cursor = ocinewcursor($this->conexao);
				
				if ($recordset1<>""){
					ocibindbyname($this->parse,":V_RESULT",&$this->cursor,-1,OCI_B_CURSOR);
					ociexecute($this->parse);
				}
				ociexecute($this->cursor) or die;*/
				break;
			case INT_POSTGRE:
				$this->Executa("begin");
				break;
			case INT_MYSQL:
				$this->Executa("begin");
				break;
		}
	}
	
	//Completa uma atualizaÁ„o
	 function CommitTrans(){
		switch ($this->intBanco){
			case INT_SQLSERVER:
				$this->Executa("commit trans");
				break;
			case INT_ORACLE:
				break;
			case INT_POSTGRE:
				$this->Executa("end");
				break;
			case INT_MYSQL:
				$this->Executa("commit");
				break;
		}
	}
	
	//D· RollBack em uma transaÁ„o iniciada
	 function RollBackTrans(){
		switch ($this->intBanco){
			case INT_SQLSERVER:
				$this->Executa("rollback trans");
				break;
			case INT_ORACLE:
				break;
			case INT_POSTGRE:
				$this->Executa("rollback");
				break;
			case INT_MYSQL:
				$this->Executa("rollback");
				break;
		}
	}
	//Testa a conex„o sem finalizar
	 function TestaConexao(){
		switch ($this->intBanco){
			case INT_SQLSERVER:
				$sBanco = "SQL";
				$this->conexao = mssql_connect($this->strBanco,$this->strUsuario,$this->strSenha);
				mssql_select_db($this->strBase,$this->conexao);
				//$this->Executa("set dateformat dmy");
				break;
			case INT_ORACLE:
				$sBanco = "Oracle";
				$this->conexao = oci_connect($this->strUsuario,$this->strSenha,$this->strConexao);
				$this->Executa("ALTER SESSION SET NLS_DATE_FORMAT ='DD/MM/YYYY HH24:MI:SS'");
				break;
			case INT_POSTGRE:
				$sBanco = "Postgres";
				$strCon = "host='$this->strBanco' port=5432 dbname='$this->strBase' user='$this->strUsuario' password='$this->strSenha'";
				//echo $strCon."<br />";
				$this->conexao = pg_connect($strCon);
				pg_set_client_encoding($this->conexao, "ISO-8859-7");
				break;
			case INT_MYSQL:
				$sBanco = "SQL";
				$this->conexao = mysql_connect($this->strBanco,$this->strUsuario,$this->strSenha);
				mysql_select_db($this->strBase,$this->conexao);
				break;
		}
		
		if($this->conexao === false){
			return false;
		}else{
			return true;
		}
	}
	
	//Efetua conex„o com o banco pegando o tipo de banco especificado
	 function Conecta(){
		switch ($this->intBanco){
			case INT_SQLSERVER:
				$sBanco = "SQL";
				$this->conexao = mssql_connect($this->strBanco,$this->strUsuario,$this->strSenha);
				mssql_select_db($this->strBase,$this->conexao) or die;
				$this->Executa("set dateformat dmy");
				break;
			case INT_ORACLE:
				$sBanco = "Oracle";
				$this->conexao = oci_connect($this->strUsuario,$this->strSenha,$this->strConexao);
				if ($this->conexao !== false){
					$this->Executa("ALTER SESSION SET NLS_DATE_FORMAT ='DD/MM/YYYY HH24:MI:SS'");
				}
				break;
			case INT_POSTGRE:
				$sBanco = "Postgres";
				$strCon = "host='$this->strBanco' port=5432 dbname='$this->strBase' user='$this->strUsuario' password='$this->strSenha'";
				//echo $strCon."<br />";
				$this->conexao = pg_connect($strCon);
				if ($this->conexao !== false){
					pg_set_client_encoding($this->conexao, "ISO-8859-7");
				}
				break;
			case INT_MYSQL:
				$sBanco = "SQL";
				$this->conexao = mysql_connect($this->strBanco,$this->strUsuario,$this->strSenha); //or die;
				mysql_select_db($this->strBase,$this->conexao);// or die;
				break;
		}
		if ($this->conexao === false){
			return false;
		}
		return true;
		
//		echo "Conectou $sBanco<br />";
	}
	
	//Encerra Conex„o com o banco
	 function Desconecta(){
		if(!isset($this->conexao)){
			return true;
		}
		switch ($this->intBanco){
			case INT_SQLSERVER:
				mssql_close($this->conexao);
				break;
			case INT_ORACLE:
				
				$this->liberaStatement();
				oci_close($this->conexao);
				unset($this->conexao);
				
				break;
			case INT_POSTGRE:
				pg_close($this->conexao);
				break;
			case INT_MYSQL:
				mysql_close($this->conexao);
				break;
		}
//		echo "Desconectou<br />";
	}
	
	//Executa uma instruÁ„o SQL
	 function Executa($strSQL,$recordset1=""){
		static $totConexoes;
		$totConexoes++;
		if (!isset($this->conexao)){
			$this->Conecta();
		}
		switch ($this->intBanco){
			case INT_SQLSERVER:
				$this->cursor = mssql_query($strSQL, $this->conexao) or die($this->getErro());
				break;
			case INT_ORACLE:
				
				$this->liberaStatement();
				
				$this->parse = oci_parse($this->conexao, $strSQL);

				if ($recordset1<>""){
					$this->cursor = oci_new_cursor($this->conexao);
					oci_bind_by_name($this->parse,":V_RESULT",$this->cursor,-1,OCI_B_CURSOR);
					oci_execute($this->parse);
				}else{
					$this->cursor = $this->parse;
				}
				return oci_execute($this->parse);
				break;
			case INT_POSTGRE:
				//echo $strSQL;
				$this->cursor = pg_query($this->conexao, $strSQL) or die($this->getErro());
				break;
			case INT_MYSQL:
				//echo $strSQL."<BR>";
				$this->cursor = mysql_query($strSQL, $this->conexao) or die(mysql_error($this->conexao));

				break;
		}
		
		if ($this->cursor === false){
			return false;
		}
		return true;
	}
    
    public function executaProcedure($query, $result1=NULL, $result2=NULL)
    {
        
		
		switch ($this->intBanco){
			case INT_SQLSERVER:
                break;
			case INT_ORACLE:
				
				//var_dump($this->strUsuario,$this->strSenha,$this->strConexao); die;
				//$conn = OCILogon('it_ptmenzan', 'mar_2000', 'pnxtl01')
				$conn = OCILogon($this->strUsuario,$this->strSenha,$this->strConexao)
                            or die("Erro na conex„o com o Oracle!");
                
                $this->Executa("ALTER SESSION SET NLS_DATE_FORMAT ='DD/MM/YYYY HH24:MI:SS'");

                //INTERPRETA 
                $sqlParsed = OCIParse($conn, $query);

                //PASSA VARI·VEIS PHP PARA O ORACLE
                if($result1 == TRUE){
                    OCIBindByName($sqlParsed, "V_RESULT1", $result1, 5); 
                }
                if($result2 == TRUE){
                    OCIBindByName($sqlParsed, "V_RESULT2", $result2, 4000); 
                }

                //EXECUTA 
                OCIExecute($sqlParsed, OCI_DEFAULT); 
                //echo '<pre>'; var_dump($result11, $sqlParsed, $query); die;
                if($result1 == TRUE){
                    $retorno[] = $result1;
                }
                if($result2 == TRUE){
                    $retorno[] = $result2;
                }
				break;
			case INT_POSTGRE:
				break;
			case INT_MYSQL:
				break;
		}
        
        return $retorno;
		
    }
	
	//Retorna o ID gerado no Insert
	function getId(){
		switch ($this->intBanco){
			case INT_SQLSERVER:
				return "";
				break;
			case INT_ORACLE:
				return "";
				break;
			case INT_POSTGRE:
				return "";
				break;
			case INT_MYSQL:
				return mysql_insert_id();
				break;
		}
		
	}
	//Retorna uma linha do Recordset
	 function Linha(){
		switch ($this->intBanco){
			case INT_SQLSERVER:
				$this->rs = mssql_fetch_array($this->cursor);
				$a1 = $this->rs;
				break;
			case INT_ORACLE:
				$a1 = oci_fetch_array ($this->cursor, OCI_BOTH);
				$this->rs = $a1;
				if ($this->rs == false){
					$this->liberaStatement();
				}
				break;
			case INT_POSTGRE:
				$this->rs = pg_fetch_array($this->cursor);
				$a1 = $this->rs;
				break;
			case INT_MYSQL:
				$this->rs = mysql_fetch_array($this->cursor, MYSQL_BOTH);
				$a1 = $this->rs;
				break;
		}
		//echo "Cria Linha <br />";
		return $a1;
	}
	
	//Retorna a mensgem de Erro do Banco
	 function getErro(){
		$erro;
		switch ($this->intBanco){
			case INT_SQLSERVER:
				$erro = mssql_get_last_message();
				break;
			case INT_ORACLE:
				$erro1 = oci_error($this->cursor);
				$erro = $erro1["message"];
				break;
			case INT_POSTGRE:
				$erro = pg_last_error($this->conexao);
				break;
			case INT_MYSQL:
				$erro = mysql_error();
				break;
		}
		return $erro;
	}
	
	 function getRows(){
		switch ($this->intBanco){
			case INT_SQLSERVER:
				$totRows = mssql_rows_affected($this->conexao);
				break;
			case INT_ORACLE:
				$totRows = ocirowcount($this->cursor);
				break;
			case INT_POSTGRE:
				$this->rs = pg_affected_rows($this->cursor);
				$a1 = $this->rs;
				break;
			case INT_MYSQL:
				$totRows = mysql_affected_rows($this->conexao);
				break;
		}
	}
	
	//Retorna as colunas do recordset
	 function &getColunas(){
		
		switch ($this->intBanco){
			case INT_SQLSERVER:
				$numcols = mssql_num_fields($this->cursor);
				for ($column=0; $column < $numcols; $column++) {
					$colname = trim(mssql_field_name($this->cursor, $column));
					$templist[$column]=$colname;					
				}
				break;
			case INT_ORACLE:
				$numcols = oci_num_fields($this->parse);
				for($column=1; $column <= $numcols; $column++){
   					$colname = trim(oci_field_name($this->cursor, $column));
					$templist[$column]=$colname;
  				}
  				break;
			case INT_POSTGRE:
				$numcols = pg_num_fields($this->cursor);
				for ($column=0; $column < $numcols; $column++) {
					$colname = trim(pg_field_name($this->cursor, $column));
					$templist[$column]=$colname;					
				}
				break;
			case INT_MYSQL:
				$numcols = mysql_num_fields($this->cursor);
				for ($column=0; $column < $numcols; $column++) {
					$colname = trim(mysql_field_name($this->cursor, $column));
					$templist[$column]=$colname;					
				}
				break;
		}
		return $templist;
	}
	
	 function &getColunaInfo($coluna1){
		switch ($this->intBanco){
			case INT_SQLSERVER:
				if ($coluna1<mssql_num_fields($this->cursor)){
					$arrayColuna["nome"] = trim(mssql_field_name($this->cursor, $coluna1)); 
			   		$arrayColuna["tipo"] = trim(mssql_field_type($this->cursor, $coluna1));
			   		$arrayColuna["tamanho"] = mssql_field_length($this->cursor, $coluna1);
			   		$arrayColuna["bytes"] = 0;
			   		$arrayColuna["decimal"] = 0;
			   		$arrayColuna["ordem"] = $coluna1;
				}
				break;
			case INT_ORACLE:
				$coluna1=$coluna1+1;
				if ($coluna1<=ocinumcols($this->cursor)){
					$arrayColuna["nome"] = trim(ocicolumnname($this->cursor, $coluna1));
			   		$arrayColuna["tipo"] = trim(ocicolumntype($this->cursor, $coluna1));
			   		$arrayColuna["tamanho"] = ocicolumnsize($this->cursor, $coluna1);
			   		$arrayColuna["bytes"] = ocicolumnscale($this->cursor, $coluna1);
			   		$arrayColuna["decimal"] = ocicolumnprecision($this->cursor, $coluna1);
			   		$arrayColuna["ordem"] = $coluna1;
				}
				break;
			case INT_POSTGRE:
				if ($coluna1<pg_numfields($this->cursor)){
					$arrayColuna["nome"] = trim(pg_fieldname($this->cursor, $coluna1));
			   		$arrayColuna["tipo"] = trim(pg_fieldtype($this->cursor, $coluna1));
			   		$arrayColuna["tamanho"] = pg_fieldsize($this->cursor, $coluna1);
			   		$arrayColuna["bytes"] = pg_fieldprtlen($this->cursor, $coluna1);
			   		$arrayColuna["decimal"] = 0;
			   		$arrayColuna["ordem"] = $coluna1;
				}
				break;
			case INT_MYSQL:
				if ($coluna1<mysql_num_fields($this->cursor)){
					$arrayColuna["nome"] = trim(mysql_field_name($this->cursor, $coluna1)); 
			   		$arrayColuna["tipo"] = trim(mysql_field_type($this->cursor, $coluna1));
			   		$arrayColuna["tamanho"] = mysql_field_len($this->cursor, $coluna1);
			   		$arrayColuna["bytes"] = 0;
			   		$arrayColuna["decimal"] = 0;
			   		$arrayColuna["ordem"] = $coluna1;
				}
				break;
		}
		return $arrayColuna;
	}
	
	 function converteTipoData($tipoData){
		$tipoData = strtolower($tipoData);
		$tiposSQL["binary"] = "binario";
		$tiposSQL["bit"] = "binario";
		$tiposSQL["char"] = "varchar";
		$tiposSQL["datetime"] = "date";
		$tiposSQL["decimal"] = "numeric";
		$tiposSQL["float"] = "numeric";
		$tiposSQL["image"] = "";
		$tiposSQL["int"] = "numeric";
		$tiposSQL["money"] = "numeric";
		$tiposSQL["nchar"] = "varchar";
		$tiposSQL["ntext"] = "";
		$tiposSQL["numeric"] = "numeric";
		$tiposSQL["nvarchar"] = "varchar";
		$tiposSQL["real"] = "numeric";
		$tiposSQL["smalldatetime"] = "date";
		$tiposSQL["smallint"] = "numeric";
		$tiposSQL["smallmoney"] = "numeric";
		$tiposSQL["sysname"] = "";
		$tiposSQL["text"] = "";
		$tiposSQL["timestamp"] = "date";
		$tiposSQL["tinyint"] = "numeric";
		$tiposSQL["uniqueidentifier"] = "numeric";
		$tiposSQL["varbinary"] = "binario";
		$tiposSQL["varchar"] = "varchar";
	
		$tiposOracle["char"] = "varchar";
		$tiposOracle["date"] = "date";
		$tiposOracle["float"] = "numeric";
		$tiposOracle["integer"] = "numeric";
		$tiposOracle["long"] = "";
		$tiposOracle["long raw"] = "";
		$tiposOracle["number"] = "numeric";
		$tiposOracle["raw"] = "binario";
		$tiposOracle["rowid"] = "";
		$tiposOracle["varchar2"] = "varchar";
		$tiposOracle["varchar"] = "varchar";
		
		$tiposPostgres["abstime"] = "date";
		$tiposPostgres["anyarray"] = "";
		$tiposPostgres["array"] = "";
		$tiposPostgres["bigint"] = "numeric";
		$tiposPostgres["bit"] = "binario";
		$tiposPostgres["boolean"] = "boolean";
		$tiposPostgres["bytea"] = "numeric";
		$tiposPostgres["\"char\""] = "varchar";
		$tiposPostgres["character"] = "varchar";
		$tiposPostgres["character varying"] = "varchar";
		$tiposPostgres["int2vector"] = "numeric";
		$tiposPostgres["integer"] = "numeric";
		$tiposPostgres["name"] = "numeric";
		$tiposPostgres["numeric"] = "numeric";
		$tiposPostgres["oid"] = "numeric";
		$tiposPostgres["oidvector"] = "numeric";
		$tiposPostgres["real"] = "numeric";
		$tiposPostgres["regproc"] = "";
		$tiposPostgres["smallint"] = "numeric";
		$tiposPostgres["text"] = "";
		$tiposPostgres["timestamp without time zone"] = "date";
		$tiposPostgres["timestamp with time zone"] = "date";
		$tiposPostgres["xid"] = "numeric";
	
		switch ($this->intBanco){
			case INT_SQLSERVER:
				return $tiposSQL[$tipoData];
			case INT_ORACLE:
				return $tiposOracle[$tipoData];
			case INT_POSTGRE:
				return $tiposOracle[$tipoData];
			case INT_MYSQL:
				return $tiposSQL[$tipoData];
		}
	}
		
	public function liberaStatement(){
		if (isset($this->parse)){
			oci_free_statement($this->parse);
			sleep(0.5);
			unset($this->cursor);
			unset($this->parse);
		}
		
	}
}

?>