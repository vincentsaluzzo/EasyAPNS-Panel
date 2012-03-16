<?php 
	require_once("config.php");
	
	
	if(!isset($_POST['appname'])) {
		exit;	
	}
	if(!isset($_POST['message'])) {
		exit;	
	}
	
	if(!function_exists("__autoload")){
	    function __autoload($class_name){
	    	$config = new EasyAPNSConfiguration();
	        require_once($config->getApnsClassForAppli($_POST['appname']).'/classes/class_'.$class_name.'.php');
	    }
	}
	
	$db = new DbConnect('localhost', 'apnsuser', 'apnspassword', 'apnsdb');
	$db->show_errors();
	
	$apns= new APNS($db);
	$pidList = explode(';', $_POST['pid']);

	settype($_POST['badge'], "int");
	foreach ($pidList as $key => $value) {
		$pid = $value;
		settype($pid, "int");
		$apns->newMessage($pid);
		$apns->addMessageAlert($_POST['message']);
		$apns->addMessageBadge($_POST['badge']);
		
		$apns->queueMessage();
	}
	
	$apns->processQueue();
?>