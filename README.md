# EasyAPNS Panel

EasyAPNS is an Admin panel made for EasyAPNS project.

## How to install

EasyAPNS Panel is multi-configuration compatible.

1. Download, Install and configure EasyAPNS on your server and your iOS Application
2. Download and Install EasyAPNS-Panel on your webserver
 * Not necessary the same folder used for install EasyAPNS
3. Configure the file "include/config.php" for run with your EasyAPNS installation

## Configuration of "config.php"

config.php file contains the main object dedicated to the configuration of EasyAPNS Panel: *EasyAPNSConfiguration*

Because EasyAPNS Panel are not direclty linked for one and only one EasyAPNS Configuration, we don't use *class_DbConnect.php* provided by EasyAPNS to connect on the database.

So the first step is the configuration of database credentials. You have to configure this 4 parameter in the class:

	* $dbUsername - Username of database 
	* $dbPassword - Password of database
	* $dbName - Name of Database
	* $dbAddress - Address of your MySQL server
	
*EasyAPNSConfiguration* provide two methods for the configuration of EasyAPNS in your server:

	* addAppli($appName, $apnsClassFilePath)
		Use to add a configuration of EasyAPNS for one of your applications
	* getApnsClassForAppli($appName)
		Use by EasyAPNS-Panel to retrieve information about application
		
You need a EasyAPNS configuration for each of your application, because you can have only one and different Apple Push certificate for each application you have.

So, now you have just to configure the different application you have configured with EasyAPNS, directly in the constructor of *EasyAPNSConfiguration*, Like this:

	$this->addAppli("MyApplicationName", "File/path/of/your/EasyAPNS/configuration");
	
Be sure that the Application name given correspond to the application name registered by EasyAPNS in the database.


## Credits

EasyAPNS-Panel is developped by [Vincent Saluzzo](http://www.vincentsaluzzo.com).

[EasyAPNS](https://github.com/manifestinteractive/easyapns) are developed by Manifest Interactive, LLC

Built-on [Bootstrap by Twitter](http://twitter.github.com/bootstrap/)
	
