<?php
require '../app/DBconnect.php';
$prepare_md5='';
$profile;
$connection = connectDB();
$connection->exec('LOCK TABLES `rights` WRITE,`profileright` WRITE'  );
$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


// geting the profiles of right deservers from the form on manager side 
foreach ($_POST as $key => $value) {

	if ($value && ($key =='right' || $key =='checklist' || $key =='value' || $key =='valueShort' || $key =='function' || $key =='reason' || $key =='category')) {
			// add to md5 the value of each input
		//echo "inline";
		$prepare_md5=$prepare_md5.$value;

	}
	else if ($value){
		// echo "\"" . $key . "\"".' : '. "\"" . $value. "\"" . ',<br0>';
		$profile[$key]=$value;
	}
}

foreach ($_POST as $key => $value) {

		echo "\"" . $key . "\"".' : '. "\"" . $value. "\"" . ',<br>';
}

	//echo $prepare_md5;
	$_md5=md5($prepare_md5);
//	echo var_dump($_md5);
// TODO: hndle multiple profiles for a right


// encoding profile to json 
$encodeProfile=json_encode($profile);

function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
//Fix parameters for the query,
$right='\''.test_input($_POST['right']).'\'';
$checklist='\''.test_input($_POST['checklist']).'\'';
$category='\''.test_input($_POST['category']).'\'';
$name='\''.test_input($_POST['name']).'\'';
$subject='\''.test_input($_POST['subject']).'\'';
$value='\''.test_input($_POST['value']).'\'';
$valueShort='\''.test_input($_POST['valueShort']).'\'';
$function='\''.test_input($_POST['function']).'\'';
$reason='\''.test_input($_POST['reason']).'\'';

	

	$sql = 'select count(*) from rights where right_key LIKE \''.$_md5.'\'';
	$statement = $connection->prepare($sql);
	$statement->execute();
	$_md5='\''.$_md5.'\'';
			//verift that there is no right with the same MD5 (duplicate right):
	$count=$statement->fetchAll()[0][0];
	if(($count)==0) {

		//update the table rights.
		$sql = "INSERT INTO `rights`(`right`,`checkList`,`category`,`name`,`subject`,`value`,`valueShort`,`function`,`reason`,`right_key`)
		values ($right,$checklist,$category,$name,$subject,$value,$valueShort,$function,$reason,$_md5)";

		//TODO: inseret the execution into try catch::::::::::::::::::::: 
		//echo '<br>111<br>';
		try {
			//echo '<br>222<br>';
			$statement = $connection->prepare($sql);
			$statement->execute();
			$sql = "SELECT MAX(ID) FROM `rights`";
			$statement = $connection->prepare($sql);
			$statement->execute();
			$rightId = $statement->fetchAll()[0][0];

		//test
			//echo "<br>".$rightId."<br>";
		//
			$rightId = '\''.$rightId.'\'';
			$encodeProfile = '\''.$encodeProfile.'\'';
			$_md5='\''.md5($encodeProfile).'\'';

		//update the table profile.
		//need to support multiple profile so USE foreach
			$sql = "INSERT INTO `profileright`(`rightID`,`profile`,`profileMD5`)
			values($rightId,$encodeProfile,$_md5)";
			$statement = $connection->prepare($sql);
			$statement->execute();
			//echo '<br>333<br>';
		} catch (Exception $e) {
			echo '<br>'.$e.'<br>';
		
		}				

	}
	else
	{

		echo 'זכות זהה כבר קיימת במערכת';
	}

	$connection->exec('UNLOCK TABLES' );
	$connection=NULL;
// need to check ENDOF session;
	?>