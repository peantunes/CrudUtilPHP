<?
class CrudUtil{
	public static function url($url){
		global $__view;
		$strView = "";
		if (isset($__view)){
			$strView = "&__view=$__view";
		}
		return "index.php?__action=$url".$strView;
	}
}
?>