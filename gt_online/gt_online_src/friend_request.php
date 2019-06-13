<?php

/* connect to database */	
$connect = mysql_connect("127.0.0.1:3306", "root", "123456");
if (!$connect) {
	die("Failed to connect to database");
}
mysql_select_db("gtonline_complete") or die( "Unable to select database");

session_start();
if (!isset($_SESSION['email'])) {
	header('Location: login.php');
	exit();
}

/* was form sumitted? */
$errorMsg = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	$friendemail = mysql_real_escape_string($_POST['friendemail']);
	
	/* validate form */
	if (empty($_POST['relationship'])) {
		$errorMsg = "Error: You must provide a relationship.";
	}
	else {
	
		$relationship = mysql_real_escape_string($_POST['relationship']);
		
		$query = "INSERT INTO friendship (email, friendemail, relationship, dateconnected) " .
				 "VALUES ('{$_SESSION['email']}', '$friendemail', '$relationship', NULL)";
		$result = mysql_query($query);
		if (!$result) {
			print '<p class="error">Error: ' . mysql_error() . '</p>';
			exit();
		}
		
		/* redirect to requests page */
		header("Location: requests.php");
	
	}

}

/* retrieve email of requested friend */
if (!isset($friendemail)) {
	$friendemail = mysql_real_escape_string($_GET['friendemail']);
}

$query = "SELECT firstname, lastname, hometown " . 
		 "FROM user " .
		 "INNER JOIN regularuser on regularuser.email = user.email " .
		 "WHERE regularuser.email = '$friendemail'";

$result = mysql_query($query);
if (!$result) {
	print '<p class="error">Error: ' . mysql_error() . '</p>';
	exit();
}

$row = mysql_fetch_array($result);
if (!$row) {
	print '<p class="error">Error: Cannot find user with email: ' . $friendemail . '</p>';
	exit();
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>GTOnline Friend Request</title>
		<link rel="stylesheet" type="text/css" href="style.css" />
	</head>
	
	<body>

		<div id="main_container">
			
			<div id="header">
				<div class="logo"><img src="images/gtonline_logo.gif" border="0" alt="" title="" /></div>       
			</div>
			
			<div class="menu">
				<ul>                                                                         
					<li><a href="profile.php">view profile</a></li>
					<li><a href="edit_profile.php">edit profile</a></li>
					<li><a href="view_friends.php">view friends</a></li>
					<li><a href="friend_search.php">search for friends</a></li>
					<li><a href="logout.php">log out</a></li>              
				</ul>
			</div>
			
			<div class="center_content">
			
				<div class="center_left">
					<div class="title_name">Request Friend</div>          
					
					<div class="features">   
						
						<div class="profile_section">
							
							<form name="requestform" action="friend_request.php" method="post">
							<table width="80%">								
								<tr>
									<td class="item_label">Name</td>
									<td><?php print $row['firstname'] . " " . $row['lastname']; ?></td>
								</tr>
								<tr>
									<td class="item_label">Hometown</td>
									<td><?php print $row['hometown']; ?></td>
								</tr>
								<tr>
									<td class="item_label">Relationship</td>
									<td><input type="text" name="relationship" /></td>
								</tr>
							</table>
							<input type="hidden" name="friendemail" value="<?php print $friendemail; ?>" />
							<a href="javascript:requestform.submit();" class="fancy_button">send</a> 
							
							</form>
																				
						</div>
						
						<?php
							if (!empty($errorMsg)) {
							print "<div class='profile_section' style='color:red'>$errorMsg</div>";
						}
						?>    
																	
			
					 </div> 
					 					   
					
				</div> 
				
				<div class="clear"></div> 
			
			</div>    

		
			<div id="footer">                                              
				<div class="right_footer"><a href="http://csstemplatesmarket.com"  target="_blank">http://csstemplatesmarket.com</a></div>       
			</div>
			
		 
		</div>

	</body>
</html>