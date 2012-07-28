<h2>Local Lista</h2>
<?
$msg = "";
$messages = $this->getMessages();
if (count($this->getMessages())>0){
	$msg = $messages[0]->getMessage(); 
}
?>
<p align="center"><?=$msg?></p>
<table border="1"> 
<tr><th>Id</th> <th>Nome</th> <th>Cidade</th>  <th>Pa&iacute;s</th> <th>Dt Cadastro</th><th>Mapa</th><th>Mapa</th></tr>
<?
$lista = $this->getParam("lista");
foreach($lista as $temp){
	?>
	<tr><td><?=$temp->getIdLocal()?></td>
	<td><a href="<?=CrudUtil::url("/local/editar/".$temp->getIdLocal())?>"><?=$temp->getNome()?></a></td>
	<td><?=$temp->getCidade()?></td>
	<td><?=$temp->getPais()?></td>
	<td><?=$temp->getDtCadastro()?></td>
	<td><img src="http://maps.google.com/maps/api/staticmap?center=<?=$temp->getLatitude().",".$temp->getLongitude()?>&zoom=15&size=120x60&maptype=roadmap&markers=color:red%7Clabel:S%7C<?=$temp->getLatitude().",".$temp->getLongitude()?>&sensor=false" /></td>
	<td><a href="<?=CrudUtil::url("/local/excluir/".$temp->getIdLocal())?>">excluir</a></td></tr>
	<?
}
?>
</table>