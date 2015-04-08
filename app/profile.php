<?php
require '../app/DBconnect.php';

$profiles;
$profile;
$myprofile;
$relevantProfiles = [];

foreach ($_POST as $key => $value) {
	//test
	// echo "\"" . $key . "\"".' : '. "\"" . $value. "\"" . ',<br>';
	$myprofile[$key]=$value;
}
//test
print_r($myprofile);
echo '<br>';
// 

$sql = 'select DISTINCT profileMD5,profile FROM profileright';

try {
	$connection = connectDB();
	$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$statement = $connection->prepare($sql);
	$statement->execute();
}

catch(PDOException $e)
{
	echo $e->getMessage();
	return null;
}	
	// may need to check that statement is not NULL
foreach($statement->fetchAll() as $k=>$v) {
	$profile=json_decode($v['profile'],true);
	$isGoodProfile = true;
	foreach($profile as $key=>$value) {
		if((strpos($key,'_MIN') == true) && ($myprofile[preg_replace('/_MIN$/s', '', $key)]<$value)) {
			$isGoodProfile=false;
		}
		else if((strpos($key,'_MAX') == true) && ($myprofile[preg_replace('/_MAX$/s', '', $key)]>$value)) {
			$isGoodProfile=false;
		}
		else if (isset($myprofile[$key])  && ($myprofile[$key])!=$value) {
			$isGoodProfile = false;
		}

		// Dynamic MAX and MIN verification
		// the command  [ preg_replace('/_MIN$/s', '', $key) ]  substring the _MIN from the Key name;

	}
	
	if($isGoodProfile) {
		array_push($relevantProfiles,$v['profileMD5']);
	}

}
echo '<br>-----<br>';
if(isset($relevantProfiles)){
	print_r($relevantProfiles);
}
else {
	echo '<br>--isEmpty---<br>';
}

$sql = 'select * from (select rightID FROM profileright Orders where ';
// A.rightID,rights.name,rights.checklist
// SELECT Customers.CustomerName, Orders.OrderID
// FROM Customers
// LEFT JOIN Orders
// ON Customers.CustomerID=Orders.CustomerID
// ORDER BY Customers.CustomerName;


foreach ($relevantProfiles as $key => $value) {
	$sql = $sql.'profileMD5='.'"'.$value.'"';
	if($key< count($relevantProfiles)-1)  {
		$sql=$sql.' OR ';
	}

}
$sql=$sql.') As A,rights WHERE A.rightID=rights.ID';
//TODO: check why input is with &quot;&quot ;
//echo '<br>'.$sql.'<br>';

try {
	$connection = connectDB();
	$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$statement = $connection->prepare($sql);
	$statement->execute();
}

catch(PDOException $e)
{
	echo $e->getMessage();
	return null;
}	

foreach($statement->fetchAll() as $k=>$v) {
	echo '<br>'.$k.' : '.print_r($v).'<br>';
}


?>


