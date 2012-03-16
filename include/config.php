<?php
	
	class EasyAPNSConfiguration {
	
		private $appList = array();
		public $dbUsername = "root"; //TO CHANGE
		public $dbPassword = "root";//TO CHANGE
		public $dbName = "apns";//TO CHANGE
		public $dbAddress = "localhost";//TO CHANGE
		
		function __construct() {
			//Add Appli directly inside the constructor
			//Like $this->addAppli("MyAppli","/file/of/class/of/EasyAPNS/in/my/server");
			
		}
		
		
		function addAppli($appName, $apnsClassFilePath) {
			$this->appList[$appName] = $apnsClassFilePath;
		}
		
		function getApnsClassForAppli($appName) {
			return $this->appList[$appName];
		}
	}
?>