<?php
	session_start();

		
			$anotherTest = $_SESSION["uid"];
			$mod = $_GET["mod"];

			$_SESSION["module-code"] = $mod;

			//echo $anotherTest."</br>"; //test if the session is working 
			//echo $mod."</br>"; //session test 
			
			$host = "mysql6.000webhost.com";
			$username = "a1804008_anas";
			$password = "Viperanas953";
			$DB_name = "a1804008_eroll";
	
			// Making a link to the Database
			$connection = mysql_connect($host, $username, $password);
			//$connection = mysql_connect($host, $username, $password)or die(mysql_error());
			//$db = mysql_select_db($DB_name,$connection)or die(mysql_error());  

		$sql = "SELECT case when attendance = 1 then 'Attended' else 'Absent' end as attendance, COUNT(*) FROM log  WHERE  module_code = '".$mod."' AND student_id = '".$id."' GROUP BY  attendance";
		$result = mysql_query($sql);

$rows = array();
while($r = mysql_fetch_array($result)) {
	$row[0] = $r[0];
	$row[1] = $r[1];
	array_push($rows,$row);
}


print json_encode($rows, JSON_NUMERIC_CHECK);
mysql_close($connection);

?> 

