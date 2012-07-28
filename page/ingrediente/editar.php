<h2>Ingrediente Editar</h2>
<? 

$obj = $CrudView->getParam("ingrediente");
$msg = "";
if (count($CrudView->getMessages())>0){
	$msg = $_messages[0]->getMessage(); 
}
?>
<p align="center"><?=$msg?></p>
<form name="gravar" method="POST" action="<?=CrudUtil::url("/ingrediente/salvar")?>">
<input type="hidden" name="idlocal" value="<?=$obj->getIdIngrediente()?>" />
<p>Nome: <input type="text" name="nome" value="<?=$obj->getNome()?>" /></p>
<p>Nome Alternativo: <input type="text" name="nomealternativo" value="<?=$obj->getNomeAlternativo()?>" /></p>
<p>Descricao: <textarea name="descricao"><?=$obj->getDescricao()?></textarea></p>
<p>Ingrediente Relacionado: <input type="text" name="idingredienterelacionado" id="idingredienterelacionado" value="<?=$obj->getIdIngredienteRelacionado()?>" /></p>
<p><input type="submit" name="gravar" value="Gravar" /></p>
</form>
