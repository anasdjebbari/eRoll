<?php		
		session_start();


			$anotherTest = $_SESSION["uid"];
			$mod = $_GET["mod"];

			$_SESSION["module-code"] = $mod;

			//echo $anotherTest."</br>"; //test if the session is working 
			//echo $mod."</br>"; //session test 


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
		

										if (!empty($_SERVER["HTTP_CLIENT_IP"])){
											 //check for ip from share internet
								 			$ip = $_SERVER["HTTP_CLIENT_IP"];
										}
										elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
											// Check for the Proxy User
											$ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
										}
										else{	
											$ip = $_SERVER["REMOTE_ADDR"];
										}

										// This will print user's real IP Address
										// does't matter if user using proxy or not
										//echo $ip."</br>";
										//this piece of code taken from this website  http://www.xpertdeveloper.com/2011/09/get-real-ip-address-using-php/
										//from Avinash, Gets the Real IP address of the Visitor using PHP


					$sql = "SELECT time, time2 FROM log where date = CURDATE() AND student_id = '".$anotherTest."'"; 
						$timeComp = mysql_query($sql);
						
						while($row = mysql_fetch_array($timeComp)){ // to go and get the data from the table 
							$start = $row['time']; // extracting the time one 
							$end = $row['time2']; // extracting the second time 
						}	

						//echo "</br>";
						//echo "Start of window: ";
						//echo $start;

						//echo "</br>";
						//echo "End of window: ";
						//echo $end;

						//^ testing purposes

						// now we extract the time from when the student hit the sign in in-order to get his current time 
						$time = gmdate('H:i:s',time() + 3600); // the server time we get is an hour back due to daylight saving time 
						//so and added hour is necessary, so its added in seconds which is 3600 seconds = 1 hour.
						//echo "Time the student hit time";
						//echo $time;

						//^ testing purposes

			if (isset($_POST['signin'])) {
				
				// a comparison is done between the time taken from the student and compared to the window
				if($time > $start && $time < $end){
					//updating the log table to sign in the student, by changing it for 0 to 1.
					$sql = "UPDATE log SET attendance = TRUE, ip = '".$ip."' WHERE student_id = '".$_SESSION["uid"]."' AND module_code = '".$mod."' AND date = CURDATE() ";
					mysql_query($sql);
					echo "</br>";
				}
				else{
					echo "Cannot Sign, Speak to lecturer";
					echo "</br>";
				}	
				
			}

			if(isset($_POST['logout'])){
				session_destroy();
				header('location:http://www.gcdsrv.com/~beast/eroll/index.php');
			}
?>
			
<html>
<head>
<link rel = "stylesheet" type = "text/css" href = "style.css">
<title>
	Student
</title>
<header>		
				<img src="erollwhite.png"  style="width:80px;height:50px" id = "logo">	
				
				<form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> method="post">
					<div id = "log"> <input type = "submit" value = "log out" name = "logout" id = "submit"/> </div>
				</form>
				
</header>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
		<script type="text/javascript">
		$(document).ready(function() {
			var options = {
				chart: {
	                renderTo: 'container',
	                plotBackgroundColor: null,
	                plotBorderWidth: null,
	                plotShadow: false
	            },
	            title: {
	                text: 'Your Attendance'
	            },
	            tooltip: {
	                formatter: function() {
	                    return '<b>'+ this.point.name +'</b>: '+ this.percentage +' %';
	                }
	            },
	            plotOptions: {
	                pie: {
	                    allowPointSelect: true,
	                    cursor: 'pointer',
	                    dataLabels: {
	                        enabled: true,
	                        color: '#000000',
	                        connectorColor: '#000000',
	                        formatter: function() {
	                            return '<b>'+ this.point.name +'</b>: '+ this.percentage +' %';
	                        }
	                    }
	                }
	            },
	            series: [{
	                type: 'pie',
	                name: 'Browser share',
	                data: []
	            }]
	        }
	        
	        $.getJSON("datas.php", function(json) {
				options.series[0].data = json;
	        	chart = new Highcharts.Chart(options);
	        });
	        
	        
	        
      	}); 
      	//http://blueflame-software.com/blog/stacked-column-chart-with-data-from-mysql-using-highcharts/  
		</script>
		<script src="http://code.highcharts.com/highcharts.js"></script>
        <script src="http://code.highcharts.com/modules/exporting.js"></script>
</head>

	<body>
		<?php

			echo '<div id ="info">'. $anotherTest.'</div>';
			echo '<div id ="info">'. $mod. '</div>';

		?>
		<div id="wrapper">
	
<?php
		
			//Printing all of the users relevent information in a table form
			echo "<table border = 1 >"; //table being created 
			echo "<tr>";

			$title = array("time" , "date", "attendance", "module code", "student No."); //the headings of the table
			
			for ($j=0; $j < count($title); $j++) { //printing out the headings
				echo "<th>".$title[$j]."</th>"; // wrapping it in a title heading 
			}
			
			echo "</tr>";

			//selecting the information to print into our table 
			$sql = "SELECT time, date, attendance, module_code, student_id FROM log WHERE student_id = '".$anotherTest."' AND module_code = '".$mod."' ";// add mod code to get more accurate readign
			$output = mysql_query($sql);

			while($row = mysql_fetch_array($output)){ // to go and get the relevent data from the table 
			echo "<tr>";	
				echo "<td>".$row["time"]."</td>";
				echo "<td>".$row["date"]."</td>";
				echo "<td>".$row["attendance"]."</td>";
				echo "<td>".$row["module_code"]."</td>";	
				echo "<td>".$row["student_id"]."</td>";
			echo "</tr>";	
			}	
			echo "</tr>";
			echo "</table>";

?>			

		<form action="" method="post" id = "admin">
			<input type = "submit" value = "SIGN" name = "signin" id = "submit"/>
		</form>

			<p>Click <a href="javascript:void(0)" onclick="toggle_visibility('popupBoxOnePosition');">here</a> to see Chart</p>

			</div><!-- wrapper end -->	

			<div id="popupBoxOnePosition">
			<div class="popupBoxWrapper">
				<div class="popupBoxContent">
					<h3>Chart of your attenedance</h3>
					<div id="container" style="min-width: 36em; height: 24em; margin: 0 auto"></div>
					<p>Click <a href="javascript:void(0)" onclick="toggle_visibility('popupBoxOnePosition');">here</a> to exit</p>
				</div>
			</div>
		</div>
		<!-- popupBoxOnePosition div is taken from an online source, written by ashrash290, 
		website wer this piec of code has been taken: 
		https://github.com/ashrash290/mart/blob/master/index2.html  -->

	</body>

	<script src="javascript.js"></script>
	<footer> <p> &copy; Beasts Inc. |  <a href="nothingyet.com">About</a>  |  Designed and develped by Beast Inc.  |  <a href="">Terms and conditions</a> </p></footer>
</html>