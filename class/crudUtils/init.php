<?
function locateController($action, &$className){
	$dir="";
	if (strpos($action,".")!==false){
		$newar = explode(".",$action);
		$__action = $newar[count($newar)-1];
		for($i=0;$i<count($newar)-1;$i++){
			$dir .= $newar[$i]."/";
		}
	}else{
		$__action = $action;
	}
	$className = ucfirst($__action).'Controller';
	return $dir.$className;
}

$__dirBase = $_SERVER["DOCUMENT_ROOT"];
$__action = $_REQUEST["__action"]; // "/local/pesquisa/$id";
if (array_key_exists("__view", $_REQUEST)){
	$__view = $_REQUEST["__view"];
	$__viewName = ucfirst($__view).'View';
}
$__className=null;
if (strpos($__action, "/")===false){
	$__classFile = locateController($__action,$__className);
}else{
	$__arrAction = explode("/", $__action);
	$__length = count($__arrAction);
	$__index = 0;
	if ($__arrAction[$__index] == ""){ //
		$__index++;
		$__controller = $__arrAction[$__index++];
	}else{
		$__controller = $__arrAction[$__index++];
	}
	if ($__length > $__index){
		$__method = $__arrAction[$__index++];
	}
	$__classFile = locateController($__controller, $__className);

	$__parsIn = "";
	if ($__length > $__index && isset($__method)){
		$__parsIn = $__arrAction[$__index];
	}

}
require_once("class/controller/$__classFile.class.php");
$__class = new $__className;
if (isset($__viewName)){
	require_once("class/view/$__viewName.class.php");
	$__class->setView(new $__viewName);
}
//Call the method dynamic
if (isset($__method)){
	$CrudView = $__class->$__method($__parsIn);
}else{
	$CrudView = $__class->begin();
}
$CrudView->openTemplateFileURL();

$cConexao->Desconecta();

?>