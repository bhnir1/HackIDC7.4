<?php
$keys = NULL;
$values = NULL;
echo '{';
foreach ($_POST as $key => $value) {
	echo "\"" . $key . "\"".' : '. "\"" . $value. "\"" . ',<br>';
	// $keys[$i]=$key;
	$values[$key]=$value;

}
echo '}';


// echo '<br>';
// if(isset($_POST[$input]))
// 	echo 'yes';
// else
// 	echo 'no';



?>

<!--  
select * from right where rights.$keys[i]==rights.$values[i] or  $values[i]==0



-->

