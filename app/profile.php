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
//print_r($myprofile);
//echo '<br>';
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
	// safty:: need to check DB
	if(!$profile)
	{
		continue;
	}
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

//echo '<br>-----<br>';
// if(isset($relevantProfiles)){
// 	print_r($relevantProfiles);
// }
// else {
// 	echo '<br>--isEmpty---<br>';
// }

$sql = 'select * from (select rightID FROM profileright Orders where ';


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

echo "<html>
<meta charset=\"UTF-8\">
<head>
	<link rel=\"stylesheet\" href=\"http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css\">
	<style>
	.frame {
		vertical-align: center;
		text-align: center;
		border:4px;
		border-style: solid;
		border-color: #000;
		/*padding: 20px 0px 20px 0px; */
		position: relative;
		margin-top: 10px;
	}

	.topRight {

	}

	.image {
		margin-left: -20px;


	}
	.subject{
		text-align: right;
		color:orange;
	}
	.name{
		text-align: right;
		color:#387FBB;
	}
	.function{
		text-align: right;
		color:#387FBB;
	}
	.value{
		text-align: right;
		color:#387FBB;
	}
	.valueShort{
		text-align: right;
		color:#387FBB;
	}
	.checkList{
		text-align: right;
		color:#387FBB;
	}
	.bottom {
			text-align: right;
		color:#387FBB;
		/*position: relative;*/
		
	}
	.reason {
			text-align: right;
		color:#387FBB;
		/*position: relative;*/
		
	}

	p {
		font-family: \"Times New Roman\";
		font-size: 20px;
	}
	</style>
</head>
<body>";


function getImage($subject){
if($subject=="מילואים")
	return "../img/army.png";
else if ($subject=="משפחה") {
	return "../img/family.png";
}
	else if ($subject=="תעסוקה"){
	return "../img/money.png";
}
		else if ($subject=="תחבורה"){
	return "../img/bike.png";
}
return  "../img/academy.png";
}

foreach($statement->fetchAll() as $k=>$v) {


$imagePath = getImage($v['subject']);

echo "	
	<div class=\"frame col-md-6 col-md-offset-3\">
		<div class=\"image col-md-4 \"><img src=\"".$imagePath."\">
		</div>
		<div class=\"topRight col-md-8\">
			<div class=\"subject\"><h1>".$v['subject']."</h1>
			</div>
			<div class=\"name\"><h2><b>סוג הזכות: </b>".$v['name']." </h2>
			</div>
			<div class=\"valueShort\"><h2><b>ההטבה:</b>".$v['valueShort']."</h2>
			</div>
			<div class=\"function\"><h2><b>למי צריך לפנות:</b>".$v['function']."</h2>
			</div>
		</div>
		<div class=\"bottom col-md-12\">
			<div class=\"value\"><h3><b>הסבר מפורט: </b>".$v['value']."
			</div></h3>
			<div class=\"checkList\"><h3><b>מה צריך לעשות?</b> ".$v['checkList']."
			</div></h3>
			<div class=\"reason\"> <h3><b>למה זה מגיע לי?</b> ".$v['reason']."
			</div></h3>
		</div>
	</div>
";





/*	echo '<br>'.$k.' : '.print_r($v).'<br>';*/
}

echo "</body>
</html>";



?>


