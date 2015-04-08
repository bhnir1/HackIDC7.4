<?php
require '../app/DBconnect.php';

$profile;
// geting the profiles of right deservers from the form on manager side 
foreach ($_POST as $key => $value) {

		if ($value && ($key !='right' && $key !='checklist')) {
		echo "\"" . $key . "\"".' : '. "\"" . $value. "\"" . ',<br>';
		$profile[$key]=$value;
		}
}
// TODO: hndle multiple profiles for a right


// encoding profile to json 
$encodeProfile=json_encode($profile);
 // echo 'var_dump:<br>';
 // echo $encodeProfile;
 // echo '<br>';


//connect to DB::
// TODO OUTsource thisa function to external file.
//TODO LOCK SESSION;



//Fix parameters for the query,
$right='\''.$_POST['right'].'\'';
$checklist='\''.$_POST['checklist'].'\'';

//TODO: verify if right already exist in DB with different ID
//update the table rights.
$sql = "INSERT INTO `rights`(`right`,`checkList`,`category`,`name`,`subject`)
			 values($right,$checklist,'NONE','NONE','NONE')";

//TODO: inseret the execution into try catch::::::::::::::::::::: 
//TODO: adding sql parser for safty  htmlspecialchar(),stripslashes()
$connection = connectDB();
			$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$statement = $connection->prepare($sql);
			$statement->execute();
$sql = "SELECT MAX(ID) FROM `rights`";
			$statement = $connection->prepare($sql);
			$statement->execute();
$rightId = $statement->fetchAll()[0][0];
//test
echo "<br>".$rightId."<br>";
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


// need to check ENDOF session;
?>