<?php

/* connect to database */	
$connect = mysql_connect("127.0.0.1:3306", "root", "123456");
if (!$connect) {
	die("Failed to connect to database");
}
mysql_select_db("gtonline_complete") or die( "Unable to select database");

$errorMsg = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	if (empty($_POST['email']) or empty($_POST['password'])) {
		$errorMsg = "Please provide both email and password.";		
	}
	else {  
		
		$email = mysql_real_escape_string($_POST['email']);
		$password = mysql_real_escape_string($_POST['password']);
		
		$query = "SELECT * FROM user WHERE email = '$email' AND password = '$password'";
		$result = mysql_query($query);
		
		if (mysql_num_rows($result) == 0) {
			/* login failed */
			$errorMsg = "Login failed.  Please try again.";
			
		}
		else {
			/* login successful */
			session_start();
			$_SESSION['email'] = $email;
			
			/* redirect to the profile page */
			header('Location: profile.php');
			exit();
		}
		
	}

}
  
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	
	<head>
		<title>GTOnline Login</title>
		<link rel="stylesheet" type="text/css" href="style.css" />
	</head>
  
	<body>

		<div id="main_container">
			<div id="header">
				<div class="logo"><img src="images/gtonline_logo.gif" border="0" alt="" title="" /></div>       
			</div>
     
			<div class="center_content">
			
				<div class="text_box">
		 
					<form action="login.php" method="post">
				  
						<div class="title">GTOnline Login</div>
							<div class="login_form_row">
							<label class="login_label">Email:</label>
							<input type="text" name="email" class="login_input" />
						</div>
										
						<div class="login_form_row">
							<label class="login_label">Password:</label>
							<input type="password" name="password" class="login_input" />
						</div>                                     
						
						<input type="image" src="images/login.gif" class="login" />                              
				  
					<form/>
				  
					<?php
					if (!empty($errorMsg)) {
						print "<div class='login_form_row' style='color:red'>$errorMsg</div>";
					}
					?>                    
						   
				</div>
			
				<div class="clear"><br/></div> 
			   
			</div>    
      
			<div id="footer">                                              
				<div class="right_footer"><a href="http://csstemplatesmarket.com"  target="_blank">http://csstemplatesmarket.com</a></div>       
			</div>
		</div>
	</body>
</html>