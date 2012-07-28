<h2>Local Editar</h2>
<? 

$obj = $this->getParam("local");
$msg = "";
if (count($this->getMessages())>0){
	$msg = $_messages[0]->getMessage(); 
}
?>
<p align="center"><?=$msg?></p>
<form name="gravar" method="POST" action="<?=CrudUtil::url('/local/salvar');?>">
<input type="hidden" name="idlocal" value="<?=$obj->getIdLocal()?>" />
<p>Nome: <input type="text" name="nome" value="<?=$obj->getNome()?>" /></p>
<p>Descricao: <textarea name="descricao"><?=$obj->getDescricao()?></textarea></p>
<p>Latitude: <input type="text" name="latitude" id="latitude" value="<?=$obj->getLatitude()?>" /></p>
<p>Longitude: <input type="text" name="longitude" id="longitude" value="<?=$obj->getLongitude()?>" /></p>
<p>Cidade: <input type="text" name="cidade" value="<?=$obj->getCidade()?>" /></p>
<p>Pa&iacute;s: <input type="text" name="pais" value="<?=$obj->getPais()?>" /></p>
<? if($obj->getLatitude() != ""){
	echo "<p><img src=\"http://maps.google.com/maps/api/staticmap?center=".$obj->getLatitude().",".$obj->getLongitude()."&zoom=14&size=300x300&maptype=roadmap&markers=color:red%7Clabel:S%7C".$obj->getLatitude().",".$obj->getLongitude()."&sensor=false\" /></p>";
} ?>
<p><input type="submit" name="gravar" value="Gravar" />
<button type="button" onclick=""></button></p>
</form>
