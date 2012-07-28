<?
$req = $this->getRequest();
$comboName = $this->getParam("comboName");
?>
<select name="<?=$comboName?>">
<?
$lista = $this->getParam("lista");
foreach($lista as $temp){
	echo "<option value=\"{$temp->getIdLocal()}\">{$temp->getNome()}</option>\n";
}
?>
</select>