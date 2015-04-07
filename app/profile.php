<?php
require '../app/DBconnect.php';

$profiles;
$myprofile;
echo '{';
//echo $_POST['callPage'] . " <br> ";
foreach ($_POST as $key => $value) {
/*if($_POST['callPage']==='right')
	{ // if the calling page is Right.html echo only if $value isn't empty
//     TODO: move to other file:::::::::
		if ($value)
		echo "\"" . $key . "\"".' : '. "\"" . $value. "\"" . ',<br>';
	}
else {*/
	echo "\"" . $key . "\"".' : '. "\"" . $value. "\"" . ',<br>';
	$myprofile[$key]=$value;
}


//}
echo '}';



echo '<br>';
$sql = 'select profileMD5,profile FROM profileright';
$connection = connectDB();
			$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$statement = $connection->prepare($sql);
			$statement->execute();
	foreach($statement->fetchAll() as $k=>$v) {
			print_r($v['profile']);
			echo '<br>';
			$temp=json_encode($v['profile']);

			echo var_dump(json_decode($temp));
			echo '<br>';
			print_r (json_decode($temp));
			// foreach((array)(json_decode($temp)) as $x=>$y)
			// {
			// 	if (!$myprofile[$x])
			// 	{
			// 		echo "CORRECT<br>";
			// 	}
			// }

			// 	echo '<br>';
		}
// echo $DBH->execute('select profileMD5,profile FROM profileright');
// $sth->setFetchMode(PDO::FETCH_ASSOC);

// echo $sth->fetch();
/*while($row = $STH->fetch()) {
    echo $row['name'] . "\n";
    echo $row['addr'] . "\n";
    echo $row['city'] . "\n";
}*/
// echo '<br>';
// if(isset($_POST[$input]))
// 	echo 'yes';
// else
// 	echo 'no';



?>

<!--  
select * from right where rights.$keys[i]==rights.$values[i] or  $values[i]==0



-->

