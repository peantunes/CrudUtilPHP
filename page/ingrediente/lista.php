<h2>Ingrediente Lista</h2>
<?
$msg = "";
$messages = $CrudView->getMessages();
if (count($CrudView->getMessages())>0){
	$msg = $messages[0]->getMessage(); 
}
?>
<p align="center"><?=$msg?></p>
<table border="1"> 
<tr><th>Id</th> <th>Nome</th> <th>Alternativo</th> <th>excluir</th></tr>
<?
$lista = $CrudView->getParam("lista");
foreach($lista as $temp){
	?>
	<tr><td><?=$temp->getIdIngrediente()?></td>
	<td><a href="?__action=/ingrediente/editar/<?=$temp->getIdIngrediente()?>"><?=$temp->getNome()?></a></td>
	<td><?=$temp->getNomeAlternativo()?></td>
	<td><a href="?__action=/ingrediente/excluir/<?=$temp->getIdIngrediente()?>">excluir</a></td></tr>
	<?
}
?>
</table>