<?php		
			session_start();
	
			$host = "gcdsrv.com";
			$username = "beast";
			$password = "dunega94";
			$DB_name = "beast_eRoll";
	
			// Making a link to the Database
			$connection = mysql_connect($host, $username, $password);
	
			//To see if we got connected or not

			if(!$connection){
			echo 'Error when connecting!';
			die();
			}
			//echo 'Success on connection to DB! <br/>';

			// Select a database to work with!
			$database = mysql_select_db($DB_name, $connection);
	
			
			// Get the information that is posted to this page
			$USERID = $_POST['username'];
			$USERPASSWORD = $_POST['password'];			
	
	if (isset($_POST['username']) && isset($_POST['password'])) {

			// Comparing the users input to the database 
			$sql = "SELECT uid, f_name, s_name, password, status FROM user WHERE uid = '$USERID' AND password = '$USERPASSWORD'"; //execute 
			$result = mysql_query($sql); // put into result


				while($row = mysql_fetch_array($result)){ // to go and get the data from the table 
				
					$stat = $row['status'];// extracting the users status
					$counter ++; //to see if he/she exists
				}		

				if ($counter > 0) { //to see if a user exists
					$_SESSION["uid"] = $_POST['username']; //we then extract that users id 				
				}

				else{
					header('location: http://www.gcdsrv.com/~beast/eroll/index.php'); //redirecting him back to the login page
					exit(); //leaves the curent page 
				}

	}
				if(isset($_POST['logout'])){
					session_destroy();
					//kill the session once log out is clicked
					//echo "<a href='http://www.gcdsrv.com/~beast/eroll/index.php'>"."confirm log out"."</a>"."<br>";
					header('location:http://www.gcdsrv.com/~beast/eroll/index.php');
				}
?>

<html>
<head>
<link rel = "stylesheet" type = "text/css" href = "style.css">
<title>
	 Home 
</title>
</head>
<div id = "homepage">
<header>		
				<img src="erollwhite.png"  style="width:80px;height:50px" id = "logo">	
				
				<form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> method="post">
					<div id = "log"> <input type = "submit" value = "log out" name = "logout" id = "submit"/> </div>
				</form>			
</header>
</div>

	<body>

		<?php
		if($stat == 's'){ // using the status letters, is going to determine the users view
			
			//extracting all the modules the student studies
			$sql = "SELECT f_name, s_name, module_code FROM user INNER JOIN student_subject ON student_id = uid WHERE uid = '$USERID'"; 
			$output = mysql_query($sql);

			//identifying and putting it into a variable
			while($row = mysql_fetch_array($output)){					

				//linkning that module to the relevent page
				echo "<a href='http://www.gcdsrv.com/~beast/eroll/student.php?mod=" . $row['module_code'] . "'>" . '<div id ="color">' .$row['module_code']. '</div>'. "</a>"."</br>";
				
				$f = $row['f_name'];//extracting the first name
				$s = $row['s_name'];// and second name 

				$names = $f. " " .$s;//joining them together for letting the user know who is logged in
			}	
			
			echo '<div id ="name">'.$names. '</div>';

		}
		
		if ($stat == 'l') {// using the status letters, is going to determine the users view
			
			//extracting all the modules the student studies
			$sql = "SELECT f_name, s_name, module_code FROM user INNER JOIN module ON lecturer_id = uid WHERE uid = '$USERID'";
			$output = mysql_query($sql);

			//identifying and putting it into a variable
			while($row = mysql_fetch_array($output)){					

			//linkning that module to the relevent page
			//this is achieved by using the get method within the link	
			echo "<a href='http://www.gcdsrv.com/~beast/eroll/lecturer.php?mod=" . $row['module_code'] . "'>" . '<div id ="color">'. $row['module_code']. '</div>'. "</a>"."</br>";
			
				$f = $row['f_name']; //extracting the first name 
				$s = $row['s_name']; //and second name 
				
				$name = $f." ".$s; //joining them together for letting the user know who is logged in
			}		

			echo '<div id ="name">'.$name. '</div>'; //printing out the name

		}

		if ($stat == 'a') {//using the status letters,is going to determine the users view
			//directing them to the admin page
			//echo "<a href='http://www.gcdsrv.com/~beast/eroll/admin.php'>" . '<div id ="color">'. "VIEW ADMIN PAGE". '</div>'. "</a>"."</br>";
			echo "<script type = text/javascript>";
			echo "window.location.href='http://www.gcdsrv.com/~beast/eroll/admin.php'"; //this sends the user straight to the admin page, 
			//reason why I didnt use the header as its already sent.
			echo "</script>";
		}		
	?>	
	</body>
			<footer> <p> &copy; Beasts Inc. |  <a href="nothingyet.com">About</a>  |  Designed and develped by Beast Inc.  |  <a href="">Terms and conditions</a> </p></footer>

</html>