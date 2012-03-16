<?php
	require_once("include/config.php");
	$config = new EasyAPNSConfiguration();
	
	$db = mysql_connect($config->dbAddress, $config->dbUsername, $config->dbPassword);
	mysql_select_db($config->dbName, $db);
	
	$queryRessource_DisinctAppName = mysql_query("SELECT DISTINCT appname FROM apns_devices ORDER BY appname ASC");
	$appNameList = array();
	while($row = mysql_fetch_assoc($queryRessource_DisinctAppName)) {
		$appNameList[] = $row["appname"];
	}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>EasyAPNS Admin Panel with Bootstrap</title>
		<link rel="stylesheet" href="css/bootstrap.css" type="all" />
		<script src="http://code.jquery.com/jquery-1.7.1.js" type="text/javascript"></script>
		<script src="js/bootstrap.js" type="text/javascript"></script>
	</head>
	<body>
		<div class="navbar navbar-fixed-top">
			<div class="navbar-inner">
				<div class="container">
					<a class="brand" href="#">
						EasyAPNS Administration Panel
					</a>
				</div>
			</div>
		</div>

		<div class="container" style="padding-top: 60px;">
			<div class="row">
				<div class="span3">
					<div class="well">
						<ul class="nav nav-list">
						<li class="active"><a href="index.php"><i class="icon-home"></i>Home</a></li>
						<li class="divider"></li>
						<?php 
							foreach ($appNameList as $key => $value) {
						 ?>
							<li class="nav-header"><?= $value ?></li>
							<li><a href="deviceslist.php?appname=<?= $value ?>"><i class="icon-th-list"></i>Devices List</a></li>
							<li class="divider"></li>
						<?php } ?>
						</ul>
					</div>
				</div>
				<div class="span9">
					<div class="well">
					</div>
				</div>
			</div>
		</div>
	</body>
</html>

<?php
	mysql_close($db);
?>