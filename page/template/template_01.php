<html>
	<head>
		<title><?=$CrudView->headTitle();?></title>
		<?=$CrudView->headMeta();?>
		<link rel="stylesheet" href="css/base.css" type="text/css" />

	</head>
	<body>
		<div id="page">
			<div id="header">
				<h1><?=$CrudView->getTitle();?></h1>
				<div id="menu-top">
					<ul><?=$CrudView->pageMenu("topMenu", "<li>#menuItem</li>")?></ul>
				</div>
			</div>
			<div id="menu-content">
				<ul><?=$CrudView->pageMenu("contentMenu", "<li>#menuItem</li>")?></ul>
			</div>
			<div id="content">
				<?=$CrudView->pageContent();?>
			</div>
			
			<div id="footer">
				<?=$CrudView->pageFooter();?>
			</div>
		</div>
	</body>
</html>