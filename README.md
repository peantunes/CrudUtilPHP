CrudUtilPHP
===========

How to Use
----------

Just use the source bellow to identify the attribs for your database. The name of the Attributs must be the same from the table, but the name always be in lower case.

Think in a table with this strcture:

	CREATE TABLE IF NOT EXISTS `tb_local` (
  	`idlocal` bigint(20) NOT NULL AUTO_INCREMENT,
  	`name` varchar(200) NOT NULL,
  	`description` varchar(500) NOT NULL,
  	`lat` double NOT NULL,
  	`long` double NOT NULL,
	  
	  PRIMARY KEY (`idlocal`)
	)

The Model Class is generated with the code below

	require_once("crudUtils/CrudInterface.class.php");

	class Local extends CrudInterface{

		public $_conecction_var = 'cConecction'; //Variable that contains a Conecction class
		public $_table_name="tb_local"; //Table name
		public $_auto_increment_field="idLocal"; //Id that have the auto_increment information
		public $_keys = "idLocal"; //Id that represent the key
	
		public $idLocal;
		public $name;
		public $descrption;
		public $lat;
		public $long;
	}

Where the name of the fields doesn't need to have the same letter case, because the script only reads lower case fields name in the database. Perhaps in future I can perform a better function.

I will explain later more informations

	


