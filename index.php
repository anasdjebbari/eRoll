<html>
	<head>
	<link rel = "stylesheet" type = "text/css" href = "style.css">
		<title>
			eRoll
		</title>
	</head>
	
	<body id = "body">
	<div id = "sup">
	
		<img src="erollwhite.png" width = 200px; length = 240px;>
		<form action="home.php" method="post">
			<h2>NEVER MISS A DAY</h2>
			</br>
			<input type = "text" name = "username" value="Username" onfocus="this.value = this.value=='Username'?'':this.value;" onblur="this.value = this.value==''?'Username':this.value;"/>
			<input type = "text" name = "password" value="Password" id="pass" onfocus="this.value = this.value=='Password'?'':this.value;" onblur="this.value = this.value==''?'Password':this.value;"/> 
			<input type = "submit" value = "Log in" id = "submit"/>
		
			</br>

			<script type="text/javascript">
				var password = document.getElementById("pass");
				password.addEventListener("click",hidepass);

				function hidepass(){ 
				// this function here allows for the user to see the word password and once clicked it would hide the letters
					if(pass != null){
						this.type = 'password';
					}
					$('html').click(function(){
						document.html.addEventListener(click,boxCloser,false);
						if(password.addEventListener(click) && pass == ""){ this.type = 'text';}
					});
				}
				
			</script>
		</form>
		</div>
			<div id="social">
				<a class="share-button5" href="https://www.pinterest.com" target="_blank"></a>
				<a class="share-button6" href="https://www.google.com" target="_blank"></a>
				<a class="share-button7" href="https://www.twitter.com" target="_blank"></a>
				<a class="share-button8" href="mailto:aj-momo@hotmail.com" target="_blank"></a>
				<a class="share-button9" href="https://www.facebook.com" target="_blank"></a>
			</div>
		</br>
		</br>
		</br>
			<footer> <p> &copy; Beasts Inc. |  <a href="nothingyet.com">About</a>  |  Designed and develped by Beast Inc.  |  <a href="">Terms and conditions</a> </p></footer>
	</body> 
</html>

