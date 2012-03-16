<?php
	require_once("include/config.php");
	$config = new EasyAPNSConfiguration();
	if(!isset($_GET["appname"])) {
		header("Location: index.php");
	}
	
	$db = mysql_connect($config->dbAddress, $config->dbUsername, $config->dbPassword);
	mysql_select_db($config->dbName, $db);
	
	$queryRessource_DisinctAppName = mysql_query("SELECT DISTINCT appname FROM apns_devices ORDER BY appname ASC");
	$appNameList = array();
	while($row = mysql_fetch_assoc($queryRessource_DisinctAppName)) {
		$appNameList[] = $row["appname"];
	}
	
	$queryRessource_forAllDevices = mysql_query("SELECT * FROM apns_devices WHERE appname='".$_GET['appname']."'");
	$allDevices = array();
	while($row = mysql_fetch_assoc($queryRessource_forAllDevices)) {
		$allDevices[] = $row;
	}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>EasyAPNS Admin Panel with Bootstrap</title>
		<link rel="stylesheet" href="css/bootstrap.css" type="all" />
		<script src="http://code.jquery.com/jquery-1.7.1.js" type="text/javascript"></script>
		<script src="js/bootstrap.js" type="text/javascript"></script>
		
		<script type="text/javascript">
			function clickOnHeaderCheckBox() {
				if($("input[id=checkedLineHeader]").attr('checked')) {
					$("input[name='checkedLine']").each( function() {
						$(this).attr('checked', true);
					});
				} else {
					$("input[name='checkedLine']").each( function() {
						$(this).attr('checked', false);
					});
				}
			}			
		
			function sendPushMessageToSelectedDevice() {
				PIDOfSelectedDevice = "";
				$("input[name='checkedLine']:checked").each( function() {
					PIDOfSelectedDevice += $(this).val() + ";";
				});
				MessageToSend = $("#sendPushModal_Message").val();
				//alert(PIDOfSelectedDevice+MessageToSend);
				var badgeNumber;
				if($("#sendPushModal_Badge").css('visibility') == 'visible') {
					badgeNumber = $("#sendPushModal_Badge").val();
				}
				$.post("include/sendPush.php", {
					"pid":PIDOfSelectedDevice.substring(0, PIDOfSelectedDevice.length-1),
					"message":MessageToSend,
					"appname":"<?= $_GET["appname"] ?>",
					"badge": badgeNumber
				}, function(data) {
					$("#sendPushModal_Response").html(data);
				});
			
			}
		</script>
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
						<li><a href="index.php"><i class="icon-home"></i>Home</a></li>
						<li class="divider"></li>
						<?php 
							foreach ($appNameList as $key => $value) {
						 ?>
							<li class="nav-header"><?= $value ?></li>
							
							<?php if($value == $_REQUEST["appname"]) { ?>
							
								<li class="active"><a href="deviceslist.php?appname=<?= $value ?>"><i class="icon-th-list"></i>Devices List</a></li>
								
							<?php } else { ?>
							
								<li><a href="deviceslist.php?appname=<?= $value ?>"><i class="icon-th-list"></i>Devices List</a></li>
								
							<?php } ?>
							
							<li class="divider"></li>
						<?php } ?>
						</ul>
					</div>
				</div>
				
				<div class="span9">
					<div class="hero-unit">
						<h1>Devices List<small> For <?= $_GET['appname'] ?></small></h1>
						
					</div>
					<div class="">
						<div class="row">
							<div class="span3">
								<a class="btn btn-primary" href="#sendPushModal" data-toggle="modal">Send Push to Selected Devices</a></li>
									
							</div>
						</div>
						<br/>
						<table class="table table-striped table- table-condensed">
							<thead>
								<tr>
									<th><input type="checkbox" id="checkedLineHeader" onclick="clickOnHeaderCheckBox()"/></th>
									<th>PID</th>
									<th>App Version</th>
									<th>Device Name</th>
									<th>Device Model</th>
									<th>Device Version</th>
									<th>Status</th>
									<th>Created</th>
									<th>Modified</th>
								</tr>
							</thead>
							<tbody>
								<?php 
									for ($i = 0; $i < count($allDevices); $i++) {
										$value = $allDevices[$i];
								 ?>
									<tr>
										<td><input type="checkbox" name="checkedLine" value="<?= $value['pid'] ?>" /></td>
										<td><?= $value['pid'] ?></td>
										<td><?= $value['appversion'] ?></td>
										<td><?= $value['devicename'] ?></td>
										<td><?= $value['devicemodel'] ?></td>
										<td><?= $value['deviceversion'] ?></td>
										<td><?= $value['status'] ?></td>
										<td><?= $value['created'] ?></td>
										<td><?= $value['modified'] ?></td>
									</tr>								
								<?php } ?>
							</tbody>
						</table>
					
					
					</div>
				</div>
			</div>
		</div>
		
		
		
		
		<div class="modal fade" id="sendPushModal">
			<div class="modal-header">
			<h2>Send a Push Message</h2>
			</div>
			<div class="modal-body">
				<div class="page-header">
					<h3>Message</h3>
				</div>
				<textarea id="sendPushModal_Message" class="input-xlarge" style="width: 98%;"></textarea>
				<div class="page-header">
					<h3>Badge</h3>
				</div>
				
				<input type="checkbox" value="" onclick="(($(this).attr('checked')) ? $('#sendPushModal_Badge').css('visibility','visible') : $('#sendPushModal_Badge').css('visibility','hidden'))" /> Add Badge <input placeholder="Badge number" type="text" id="sendPushModal_Badge" style="visibility: hidden;"/> 

				<div id="sendPushModal_Response"></div>
			</div>
			<div class="modal-footer">
			<button class="btn">Cancel</button>
			<button class="btn btn-primary btn-large" onclick="sendPushMessageToSelectedDevice()">Send Push</button>
			</div>
		</div>
	</body>
</html>

<?php
	mysql_close($db);
?>