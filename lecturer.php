<?php		
		session_start();

			$anotherTest = $_SESSION["uid"];
			$mod = $_GET["mod"];

			$_SESSION["module-code"] = $mod;

			//echo $anotherTest."</br>";
			//echo $mod."</br>";



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
			
			// Get the information that is posted to this page
			$USERID = $_POST['username'];
			$USERPASSWORD = $_POST['password'];			


			// this o going to generate a new sign in list for the students 
			if (isset($_POST['gen'])) {
				$sql = "SELECT date, module_code FROM log WHERE date = CURDATE() and module_code = '".$_SESSION["module-code"]."'";
				$duplicate2 = mysql_query($sql);

				$n=0;
				$count=0;

				//reason we have this is because we wer having duplicante data 
				//so one way to stop that is to have if statements
				while ($row = mysql_fetch_array($duplicate2)) {
					$arrayofdata[$n] = $row;
					$n++;
					$count++;
				}

				if($count==0){
					//creates a sign in list without any duplicants 
					$sql = "INSERT INTO log (time, date, student_id, module_code, time2) SELECT CURTIME(),CURDATE(),student_id, module_code, CURTIME( ) + 1000 FROM student_subject WHERE module_code = '".$_SESSION["module-code"]."'";
					mysql_query($sql);
					//sucess
				}
				else{
					echo "List already generated";
				}	
		
					//echo "list Generated successfully";
			}

				if(isset($_POST['logout'])){
					session_destroy();
					//kill the session once log out is clicked
					//echo "<a href='http://www.gcdsrv.com/~beast/eroll/index.php'>"."confirm log out"."</a>"."<br>";
					header('location:http://www.gcdsrv.com/~beast/eroll/index.php');
				}


			if (isset($_POST['add'])){
				
				if($_POST["newSnum"] !="" && $_POST["newFname"] !="" && $_POST["newSname"] !="" && $_POST["newEmail"] !="" && $_POST["newPassword"]){

				function Validator ($newSnum, $newFname, $newSname, $newEmail ,$newPassword){ //create a function for name checking using different rules which are set
				
					$sNum = '/^[0-9]{7,}/'; 
					$fName ='/^[A-Z a-z]{2,}/';// ba is why two is the minum or li 	
					$sName ='/^[A-Z a-z]{2,}/';	
					$eMail = '/^[a-z\d\._-]+@([a-z\d-]+\.)+[a-z]{2,6}$/i';
					$pWord = '/^[A-Z a-z 0-9]{6,}/';


					if (preg_match($sNum,$newSnum) && preg_match($fName,$newFname) && preg_match($sName,$newSname) && preg_match($eMail,$newEmail) && preg_match($pWord,$newPassword)){ 
					//preg_match is used to test if the users input equals the rules which are already set
   						echo $newFname." ".$newSname.' Is added to '. $mod;
					
   						$sql = "INSERT INTO user VALUES ('".$_POST['newSnum']."', '".$_POST['newFname']."', '".$_POST['newSname']."', '".$_POST['newEmail']."', 's', '".$_POST['newPassword']."')";
						//echo "the button is working";
						$info = mysql_query($sql);

						$sql = "INSERT INTO student_subject VALUES ('".$_SESSION["module-code"]."','".$_POST['newSnum']."')";
						$subject = mysql_query($sql);
					} 	
					
					else{ //if they arent, identify where the mistake is and notify the user 
   						if (!preg_match($sNum,$newSnum)){
   							echo 'Studen Number doesnt match';	
   							echo "</br>";
   						}
   						if (!preg_match($fName,$newFname)){
   							echo 'Invalid first Name';	
   							echo "</br>";
   						}	
   						if(!preg_match($sName,$newSname)){
   							echo 'Invalid Last Name';	
   							echo "</br>";
   						}
   						if(!preg_match($eMail,$newEmail)){
   							echo 'Invalid Email';	
   							echo "</br>";
   						}
   						if(!preg_match($pWord,$newPassword)){
   							echo 'Invalid Password';	
   							echo "</br>";
   						}
    				}


   				}

   			 echo Validator($_POST["newSnum"], $_POST["newFname"], $_POST["newSname"], $_POST["newEmail"], $_POST["newPassword"]);	//this executes the code by putting the input into the function

   			}

   			else{
   				echo "Empty fields, try agin";
   			}

		}

			if(isset($_POST['remove'])){
				//removing a student follows the same principles as the add only differs in the sql statements
				if($_POST["studentNum"] !=""){
					$sql1 = "DELETE FROM student_subject WHERE student_id = '".$_POST['studentNum']."' ";
					mysql_query($sql1);
					$sql2 = "DELETE FROM log WHERE student_id = '".$_POST['studentNum']."' ";
					mysql_query($sql2);
					//echo "Student is removed from the database successfully";
				}
				else{
   					echo "Empty field try agin";
   				}	
			}

			if(isset($_POST['searchdate'])){
			
				//$day = $_POST["day"];
				//echo $day;
				
				//echo "-";

				//$month = $_POST["month"];
				//echo $month;

				//echo "-";

				//$year = $_POST["year"];
				//echo $year;

				//echo "</br>";

				//$finaldate = $year."/".$month."/".$day;
				//echo $finaldate;
				
				//^ testing purposes

				//uses the input to find the required informtion 
				$sql = "SELECT time, date, student_id, f_name, s_name, attendance FROM log INNER JOIN user ON student_id = uid WHERE date = '".$finaldate."' ";
				$searched = mysql_query($sql);

				while($row = mysql_fetch_array($searched)){ // to go and get the data from the table 
					echo " </br>";
					echo "[";
					echo $row["time"]."][";
					echo $row["student_id"]."][";
					echo $row["f_name"]."][";
					echo $row["s_name"]."][";	
					echo $row["attendance"]."]";
					echo "</br>";
				}	
			}

			if(isset($_POST['searchStudent'])){
				//searches using the student id and module code 
				$sql = "SELECT time, date, student_id, f_name, s_name, attendance FROM log INNER JOIN user ON student_id = uid WHERE student_id = '".$_POST['studentId']."' && module_code = '".$mod."' ";
				$output = mysql_query($sql);

				//echo "searching student works";
				//echo $_POST['studentId'];

				while($row = mysql_fetch_array($output)){ // to go and get the data from the table 
					echo " </br>";
					echo "[";
					echo $row["time"]."][";
					echo $row["date"]."][";
					echo $row["student_id"]."][";
					echo $row["f_name"]."][";
					echo $row["s_name"]."][";	
					echo $row["attendance"]."]";
					echo "</br>";
				}	

			}

			if(isset($_POST['signstudent'])){
				//sign in a student who has missed the sign in window
				//this is simply going to update the log table incase the student forgot to sign in
				$sql = "UPDATE log SET attendance = TRUE, ip = '".$ip."' WHERE student_id = '".$_POST['studentnum']."' AND module_code = '".$mod."' AND date = CURDATE() ";
					mysql_query($sql);
			}

?>

			
<html>
<head>
<link rel = "stylesheet" type = "text/css" href = "style.css">
<title>
 Lecturer
</title>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			var options = {
	            chart: {
	                renderTo: 'container',
	                type: 'column',
	                marginRight: 130,
	                marginBottom: 25
	            },
	            title: {
	                text: 'Student Daily Attendance',
	                x: -20 //center
	            },
	            subtitle: {
	                text: '',
	                x: -20
	            },
	            xAxis: {
	                categories: []
	            },
	            yAxis: {
	                title: {
	                    text: 'Students'
	                },
	                plotLines: [{
	                    value: 0,
	                    width: 1,
	                    color: '#808080'
	                }]
	            },
	            tooltip: {
	                formatter: function() {
	                        return '<b>'+ this.series.name +'</b><br/>'+
	                        this.x +': '+ this.y;
	                }
	            },
	            legend: {
	                layout: 'vertical',
	                align: 'right',
	                verticalAlign: 'top',
	                x: -10,
	                y: 100,
	                borderWidth: 0
	            },
	             plotOptions: {
	                column: {
	                    stacking: 'normal',
	                    dataLabels: {
	                        enabled: true,
	                        color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
	                    }
	                }
	            },
	            series: []
	        }
	        
	        $.getJSON("data.php", function(json) {
				options.xAxis.categories = json[0]['data'];
	        	options.series[0] = json[1];
	        	options.series[1] = json[2];
		        chart = new Highcharts.Chart(options);
	        });
	    });
	//http://blueflame-software.com/blog/highcharts-pie-chart-php-mysql-example/
		</script>

<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>
</head>
<header>		
				<img src="erollwhite.png"  style="width:80px;height:50px" id = "logo">	
				
				<form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> method="post">
					<div id = "log"> <input type = "submit" value = "log out" name = "logout" id = "submit"/> </div>
				</form>
				
</header>	
	<body>
		<?php

			echo '<div id ="info">'. $anotherTest.'</div>';
			echo '<div id ="info">'. $mod. '</div>';

		?>

		<div id="wrapper">

			<div id="ButtonSpace">
				<input type = "button" id = "button1" class="NoneActive1" value = "Add Student"/>
				<input type = "button" id = "button2" class="NoneActive2" value = "Remove Student" />
				<input type = "button" id = "button3" class="NoneActive3" value = "Search Student"/>	
				<input type = "button" id = "button4" class="NoneActive4" value = "Search Date"/>	

		<div id ="buttons">
		<form action="" method="post" name = "Add">
			<input type = "text" name = "newSnum" value = "Student Number" onfocus="if (this.value=='Student Number') this.value='';" onblur="this.value = this.value==''?'Student Number':this.value;"/>
			<input type = "text" name = "newFname" value = "First Name" onfocus="if (this.value=='First Name') this.value='';" onblur="this.value = this.value==''?'First Name':this.value;"/>
			<input type = "text" name = "newSname" value = "Surname" onfocus="if (this.value=='Surname') this.value='';" onblur="this.value = this.value==''?'Surname':this.value;"/>
			<input type = "text" name = "newEmail" value = "Email" onfocus="if (this.value=='Email') this.value='';" onblur="this.value = this.value==''?'Email':this.value;"/>
			<input type = "text" name = "newPassword" value = "Password" onfocus="if (this.value=='Password') this.value='';" onblur="this.value = this.value==''?'Password':this.value;"/>

			<input type = "submit" value = "Add Student" name = "add" id = "submit"/>
		</form>

		<form action="" method="post" name = "Remove">
			<input type = "text" name = "studentNum" value = "Student Number" onfocus="if (this.value=='Student Number') this.value='';" onblur="this.value = this.value==''?'Student Number':this.value;"/>
			<input type = "submit" value = "Remove Student" name = "remove" id = "submit"/>
		</form>

		<form action=""method="post" name = "SearchDate">
		<select name="day">
				<option value="01">1</option>
				<option value="02">2</option>
				<option value="03">3</option>
				<option value="04">4</option>
				<option value="05">5</option>
				<option value="06">6</option>
				<option value="07">7</option>
				<option value="08">8</option>
				<option value="09">9</option>
				<option value="10">10</option>
				<option value="11">11</option>
				<option value="12">12</option>
				<option value="13">13</option>
				<option value="14">14</option>
				<option value="15">15</option>
				<option value="16">16</option>
				<option value="17">17</option>
				<option value="18">18</option>
				<option value="19">19</option>
				<option value="20">20</option>
				<option value="21">21</option>
				<option value="22">22</option>
				<option value="23">23</option>
				<option value="24">24</option>
				<option value="25">25</option>
				<option value="26">26</option>
				<option value="27">27</option>
				<option value="28">28</option>
				<option value="29">29</option>
				<option value="30">30</option>
				<option value="31">31</option>
		</select>

		<select name="month">
				<option value="01">Jan</option>
				<option value="02">Feb</option>
				<option value="03">Mar</option>
				<option value="04">Apr</option>
				<option value="05">May</option>
				<option value="06">Jun</option>
				<option value="07">Jul</option>
				<option value="08">Aug</option>
				<option value="09">Sep</option>
				<option value="10">Oct</option>
				<option value="11">Nov</option>
				<option value="12">Dec</option>
		</select>

		<select name="year">
				<option value="2013">2013</option>
				<option value="2014">2014</option>
				<option value="2015">2015</option>
				<option value="2016">2016</option>
				<option value="2017">2017</option>
				<option value="2018">2018</option>
		</select>

		<input type = "submit" value = "Search" name = "searchdate" id = "submit"/>
		</form>
			<form action="" method="post" name = "SearchStudent">
				<input type = "text" name = "studentId" value = "Student Number" onfocus="if (this.value=='Student Number') this.value='';" onblur="this.value = this.value==''?'Student Number':this.value;"/>
				<input type = "submit" value = "search Student" name = "searchStudent" id = "submit"/>
			</form>	

			<form action="" method="post" name = "signstudent">
				<input type = "text" name = "studentnum" value = "Student Number" onfocus="if (this.value=='Student Number') this.value='';" onblur="this.value = this.value==''?'Student Number':this.value;"/>
				<input type = "submit" value = "sign in" name = "searchStudent" id = "submit"/>
			</form>	

		</div>		

		</div>
<?php

			//Printing all of the users relevent information in a table form
			
			echo "<table border = 1 >"; //table being created 
			echo "<tr>";

			$title = array("time" , "date", "attendance", "module code", "student No."); //the headings of the table
			
			for ($j=0; $j < count($title); $j++) { //printing out the headings
				echo "<th>".$title[$j]."</th>"; // wrapping it in a title heading 
			}
			
			echo "</tr>";

			$sql = "SELECT time, date, attendance, module_code, student_id FROM log WHERE module_code = '".$mod."' ";// add mod code to get more accurate readign
			$output = mysql_query($sql);

			while($row = mysql_fetch_array($output)){ // to go and get the data from the table 
			echo "<tr>";	
				echo "<td >".$row["time"]."</td>";
				echo "<td>".$row["date"]."</td>";
				echo "<td>".$row["attendance"]."</td>";
				echo "<td>".$row["module_code"]."</td>";	
				echo "<td>".$row["student_id"]."</td>";
			echo "</tr>";	
			}	
			
			
			$sql1 = "SELECT COUNT(attendance) FROM  log WHERE attendance = 0 AND date = CURDATE() AND  module_code = '".$mod."'";
			$out = mysql_query($sql1);
			
			while($row = mysql_fetch_array($out)){ 
				$count1 = $row['COUNT(attendance)'];
			}	


			$sql2 = "SELECT COUNT(attendance) FROM  log WHERE attendance = 1 AND date = CURDATE() AND  module_code = '".$mod."'";
			$out1 = mysql_query($sql2);

			while($row = mysql_fetch_array($out1)){ 
				$count2 = $row['COUNT(attendance)'];
			}	
			echo "<td class='hed' colspan = '8'>"."Amount of Students absent: ".$count1. " | ". "Amount of Students attended: ".$count2. "</td>"; // students who are absent and present
	
			echo "</tr>";
			echo "</table>";
?>			
				
			<form action="" method="post">
				<div id = "gen"> <input type = "submit" value = "Generate" name = "gen" id = "submit"/> </div>
			</form>

			<p>Click <a href="javascript:void(0)" onclick="toggle_visibility('popupBoxOnePosition');">here</a> to see Chart</p>
	</div><!-- wrapper end -->				

		<div id="popupBoxOnePosition">
			<div class="popupBoxWrapper">
				<div class="popupBoxContent">
					<h3>Chart Of students attenedance</h3>
					<div id="container" style="min-width: 36em; height: 24em; margin: 0 auto"></div>
					<p>Click <a href="javascript:void(0)" onclick="toggle_visibility('popupBoxOnePosition');">here</a> to exit</p>
				</div>
			</div>
		</div>
		<!-- popupBoxOnePosition div is taken from an online source, written by ashrash290, 
		website were this piece of code was been taken from: 
		https://github.com/ashrash290/mart/blob/master/index2.html  -->

	</body>	
	<footer> <p> &copy; Beasts Inc. |  <a href="nothingyet.com">About</a>  |  Designed and develped by Beast Inc.  |  <a href="">Terms and conditions</a> </p></footer>
	<script src="javascript.js"></script>
</html>










