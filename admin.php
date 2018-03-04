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
	
			// Select a database to work with!
			$database = mysql_select_db($DB_name, $connection);

			//This code allows us add a student and lecturer to database and their modules///////////////////////////////////////////////////////////////////////
			
			if($_POST["newLnum"] !="" && $_POST["newLnum"] !="Lecturer Number" && $_POST["newFname"] !="" && $_POST["newFname"] !="First Name" && $_POST["newSname"] !="" && $_POST["newSname"] !="Surname" && $_POST["newEmail"] !="" && $_POST["newEmail"] !="Email" && $_POST["newPassword"] !="" && $_POST["newPassword"] !="Password" ){
			//make sure user does not send useless data to the database	
				if(isset($_POST['newLnum'])){//check the if the first iput box is set
				
					$newLnum = $_POST['newLnum'];
					$newFname = $_POST['newFname'];
					$newSname = $_POST['newSname'];
					$newPassword = $_POST['newPassword'];
					//reference
					//http://webintersect.com/articles/64/javascript-add-more-form-fields
					//LewisAnderson 
					// this code allows us to add and remove fields if the user needs to add the lecturer or student to multiple modules
					$childlist = "";	
					$more = TRUE;
					$i = 1;
					while ($more){
						if ((isset($_POST['child_'.$i])) && ($_POST['child_'.$i] != "Choose")){
							$childlist .= $_POST['child_'.$i];
							$childlist .= "<br />";
						} else {
							$more = FALSE;
						}
					$i++;
					}
					if(isset($_POST['addLec'])){
					
						//add a new lecturer to the user table
   						$sql = "INSERT INTO user VALUES ('".$_POST['newLnum']."', '".$_POST['newFname']."', '".$_POST['newSname']."', '".$_POST['newEmail']."', 'l', '".$_POST['newPassword']."')";
						
						$info = mysql_query($sql, $connection) or die(mysql_error());//query the sql statement;
						//This allows the user select all the modules the new lecturer is doing so he does not have to repeat the process 
						if(isset($_POST['child_1'])){//check if each tab has data in it
							$sub=$_POST['child_1'];
							$sql = "INSERT INTO module VALUES ('".$sub."', 'none' ,'".$_POST['newLnum']."')";
							$subject = mysql_query($sql) or die(mysql_error());
						}
						if(isset($_POST['child_2'])){//check if each tab has data in it
							$sub1=$_POST['child_2'];
							$sql = "INSERT INTO module VALUES ('".$sub1."', 'none' ,'".$_POST['newLnum']."')";
							$subject = mysql_query($sql) or die(mysql_error());
						}
						if(isset($_POST['child_3'])){//check if each tab has data in it
							$sub2=$_POST['child_3'];
							$sql = "INSERT INTO module VALUES ('".$sub2."', 'none' ,'".$_POST['newLnum']."')";
							$subject = mysql_query($sql) or die(mysql_error());
						}
						if(isset($_POST['child_4'])){//check if each tab has data in it
							$sub3=$_POST['child_4'];
							$sql = "INSERT INTO module VALUES ('".$sub3."', 'none' ,'".$_POST['newLnum']."')";
							$subject = mysql_query($sql) or die(mysql_error());
						}
						echo $newFname." ".$newSname.' Is added to Database ';
					}
					elseif(isset($_POST['addStu'])){
						//add a new Student to the user table
   						$sql = "INSERT INTO user VALUES ('".$_POST['newLnum']."', '".$_POST['newFname']."', '".$_POST['newSname']."', '".$_POST['newEmail']."', 's', '".$_POST['newPassword']."')";
						
						$info = mysql_query($sql, $connection) or die(mysql_error());//query the sql statement;
						//This allows the user select all the modules the new Student is doing so he does not have to repeat the process 
						if(isset($_POST['child_1'])){//check if each tab has data in it
							$sub=$_POST['child_1'];
							$sql = "INSERT INTO student_subject VALUES ('".$sub."','".$_POST['newLnum']."')";
							$subject = mysql_query($sql) or die(mysql_error());
						}
						if(isset($_POST['child_2'])){//check if each tab has data in it
							$sub1=$_POST['child_2'];
							$sql = "INSERT INTO student_subject VALUES ('".$sub1."','".$_POST['newLnum']."')";
							$subject = mysql_query($sql) or die(mysql_error());
						}
						if(isset($_POST['child_3'])){//check if each tab has data in it
							$sub2=$_POST['child_3'];
							$sql = "INSERT INTO student_subject VALUES ('".$sub2."', '".$_POST['newLnum']."')";
							$subject = mysql_query($sql) or die(mysql_error());
						}
						if(isset($_POST['child_4'])){//check if each tab has data in it
							$sub3=$_POST['child_4'];
							$sql = "INSERT INTO student_subject VALUES ('".$sub3."','".$_POST['newLnum']."')";
							$subject = mysql_query($sql) or die(mysql_error());
						}
						echo $newFname." ".$newSname.' Is added to Database ';
						
					
					}
				}
			}
			/////////////////////////////////end of code for adding//////////////////////////////////////////////////////////////////////////////////////////////
				
			////////////////////////////////Remove student or lecturer from database///////////////////////////////////////////////////////////////////

			if(isset($_POST['removeStu'])){//remove student from database
				if($_POST["userNum"] !=""){//check if field not empty
					$sql1 = "DELETE FROM student_subject WHERE student_id = '".$_POST['userNum']."' ";//delete from student_subject table
					mysql_query($sql1) or die(mysql_error());
					$sql2 = "DELETE FROM log WHERE student_id = '".$_POST['userNum']."' ";//delete from log table
					mysql_query($sql2) or die(mysql_error());
					$sql3 = "DELETE FROM user WHERE uid = '".$_POST['userNum']."' ";//delete from user table
					mysql_query($sql3) or die(mysql_error());
					echo "Student is removed from the database successfully";
				}
				else{
   					echo "Empty field try again";
   				}	
			}
			if(isset($_POST['removeLec'])){//remove lecturer from database
				if($_POST["userNum"] !=""){
					$sql1 = "DELETE FROM module WHERE lecturer_id = '".$_POST['userNum']."' ";//delete from module table
					mysql_query($sql1) or die(mysql_error());
					$sql2 = "DELETE FROM user WHERE uid = '".$_POST['userNum']."' ";//delete from user table
					mysql_query($sql2) or die(mysql_error());
					echo "Lecturer is removed from the database successfully";
				}
				else{
   					echo "Empty field try again";
   				}	
			}

		////////////////////////////end of code for removing////////////////////////////////////////////////////////////////////////////////////////////////
   			
		////////////////////////////Search for student and lecturer/////////////////////////////////////////////////////////////////////////////////////////
		
		if(isset($_POST['searchStu'])){//student details
			if($_POST["userId"] !=""){//check if field not empty
		
				echo "<table border='4' class='stats' cellspacing='0'>";//print the details in table form

				echo '<tr>';
				$tablehead = array ("Student ID ", "First Name ", "Surname ", "Email ", "Module Code ");
				for($i=0; $i<count($tablehead); $i++){//print the table heads
					echo '<th>'. $tablehead[$i] .'</th>';
				}
				echo '</tr>';
				//get details of the student by sql statement
				$sql = "SELECT  student_id, f_name, s_name , email, module_code FROM user INNER JOIN student_subject ON student_id = uid WHERE student_id = '".$_POST['userId']."'  ";
				$output = mysql_query($sql) or die(mysql_error());

				while($row = mysql_fetch_array($output)){ // to go and get the data from the table 
					echo '<tr>';
					
					echo '<td>'.$row["student_id"]."</td>";
					echo '<td>'.$row["f_name"]."</td>";
					echo '<td>'.$row["s_name"]."</td>";
					echo '<td>'.$row["email"]."</td>";
					echo '<td>'.$row["module_code"]."</td>";
					echo '</tr>';
				}
				echo '</tr>';
				echo'</table>';	
			}
			else{
				echo "Empty field try again";
			}
		}
		if(isset($_POST['searchLec'])){//Lecturer details
			if($_POST["userId"] !=""){//check if field not empty
		
				echo "<table border='4' class='stats' cellspacing='0'>";//print the details in table form

				echo '<tr>';
				$tablehead = array ("Lecturer ID ", "First Name ", "Surname ", "Email ", "Module Code ");
				for($i=0; $i<count($tablehead); $i++){//print the table heads
					echo '<th>'. $tablehead[$i] .'</th>';
				}
				echo '</tr>';
				//get details of the lecturer by sql statement
				$sql = "SELECT  lecturer_id, f_name, s_name , email, module_code FROM user INNER JOIN module ON lecturer_id = uid WHERE lecturer_id = '".$_POST['userId']."'  ";
				$output = mysql_query($sql) or die(mysql_error());

				while($row = mysql_fetch_array($output)){ // to go and get the data from the table 
					echo '<tr>';
					
					echo '<td>'.$row["lecturer_id"]."</td>";
					echo '<td>'.$row["f_name"]."</td>";
					echo '<td>'.$row["s_name"]."</td>";
					echo '<td>'.$row["email"]."</td>";
					echo '<td>'.$row["module_code"]."</td>";
					echo '</tr>';
				}
				echo '</tr>';
				echo'</table>';	
			}
			else{
				echo "Empty field try again";
			}

		}

		if(isset($_POST['logout'])){
					session_destroy();
					//kill the session once log out is clicked
					//echo "<a href='http://www.gcdsrv.com/~beast/eroll/index.php'>"."confirm log out"."</a>"."<br>";
					header('location:http://www.gcdsrv.com/~beast/eroll/index.php');
		}
		///////////////////////the end of code for searching////////////////////////////////////////////////////////////////////////////////////////////////
			
			
?>
<!DOCTYPE html>
<html>
<head>
<title> Admin </title>
<meta charset="UTF-8">
<link rel = "stylesheet" type = "text/css" href = "style.css">
<script type="text/javascript">
var i = 1;
function addKid(){////http://webintersect.com/articles/64/javascript-add-more-form-fields developed by LewisAnderson
	if (i <= 3){
		i++;	
    	var div = document.createElement('div');
		div.style.width = "300px";
		div.style.height = "50px";
		div.style.color = "white";
		div.setAttribute('class', 'myclass');
    	div.innerHTML = 'Subject : <select name="child_'+i+'" ><option value="">Choose</option><option value="BSCH-SWD">BSCH-SWD</option><option value="BSCH-DSA">BSCH-DSA</option><option value="BSCH-LA">BSCH-LA</option><option value="BSCH-OSD">BSCH-OSD</option></select><input type="button" id="add_kid()" onClick="addKid()" value="+" /><input type="button" value="-" onclick="removeKid(this)">';
    	document.getElementById('kids').appendChild(div);
	}
}

function removeKid(div) {	
    document.getElementById('kids').removeChild( div.parentNode );
	i--;
}
</script>
</head>
<header>		
				<img src="erollwhite.png"  style="width:80px;height:50px" id = "logo">	
				
				<form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> method="post">
					<div id = "log"> <input type = "submit" value = "log out" name = "logout" id = "submit"/> </div>
				</form>
				
</header>	
<body>
	<div id="admin">
	<form action="" method="post" name= "addLecturer" >
	Add Lecturer and Student And their Modules to Database
</br>
</br>
			<input type = "text" name = "newLnum" value = "User Number" onfocus="if (this.value=='User Number') this.value='';" onblur="this.value = this.value==''?'User Number':this.value;"/>
			<input type = "text" name = "newFname" value = "First Name" onfocus="if (this.value=='First Name') this.value='';" onblur="this.value = this.value==''?'First Name':this.value;" />
			<input type = "text" name = "newSname" value = "Surname" onfocus="if (this.value=='Surname') this.value='';" onblur="this.value = this.value==''?'Surname':this.value;"/>
			<input type = "text" name = "newEmail" value = "Email" onfocus="if (this.value=='Email') this.value='';" onblur="this.value = this.value==''?'Email':this.value;"/>
			<input type = "text" name = "newPassword" value = "Password" onfocus="if (this.value=='Password') this.value='';" onblur="this.value = this.value==''?'Password':this.value;"/>

		</br>
		</br>
			<div id="kids">
			Subject:
			<select name= "child_1">
				<option value="">Choose</option>
				<option value="BSCH-SWD">BSCH-SWD Server Side Web Development</option>
				<option value="BSCH-DSA">BSCH-DSA Data Structures & Algorithms</option>
				<option value="BSCH-LA">BSCH-LA Linear Algebra</option>
				<option value="BSCH-OSD">BSCH-OSD Operating System Design</option>
			</select>			
			<input type="button" id="add_kid()" onClick="addKid()" value="+" />(limit 4)
			</div>
			</br>
			<input type="submit" name="addLec" value="Lecturer" id="submit" />
			<input type="submit" name="addStu" value="Student" id="submit" />
	</form>
	</br>
	<form action="" method="post" name = "Remove">
	Remove Student or Lecturer from Database
			<input type = "text" name = "userNum" value = "User Number" onfocus="if (this.value=='User Number') this.value='';" onblur="this.value = this.value==''?'User Number':this.value;" />
			<input type = "submit" value = "Remove Student" name = "removeStu" id = "submit"/>
			<input type = "submit" value = "Remove Lecturer" name = "removeLec" id = "submit"/>
	</form>
	</br>
	<form action="" method="post" name = "Search">
	Search for Lecturer or Student Details
				<input type = "text" name = "userId" value = "User Number" onfocus="if (this.value=='User Number') this.value='';" onblur="this.value = this.value==''?'User Number':this.value;"/>
				<input type = "submit" value = "search Student" name = "searchStu" id = "submit"/>
				<input type = "submit" value = "search Lecturer" name = "searchLec" id = "submit"/>
	</form>	
</div>
	</body> 
	<footer> <p> &copy; Beasts Inc. |  <a href="nothingyet.com">About</a>  |  Designed and develped by Beast Inc.  |  <a href="">Terms and conditions</a> </p></footer>
</html>