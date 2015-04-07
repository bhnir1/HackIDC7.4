<?php


function connectDB(){
$servername = "localhost";
$username = "admin";
$password = "admin";
$dbname="hackidc";
	
try {
    $connection = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    //echo "Connected successfully";
	$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		//SET UTF8 - FOR HEBREW support:
	return $connection;
    }

catch(PDOException $e)
    {
    echo $e->getMessage();
	return null;
    }	

}


?>