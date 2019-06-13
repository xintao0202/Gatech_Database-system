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

$query = "SELECT firstname, lastname " .
		 "FROM user " .
		 "WHERE user.email = '{$_SESSION['email']}'";
		 
$result = mysql_query($query);
if (!$result) {
	print "<p>Error: " . mysql_error() . "</p>";
	exit();
}

$row = mysql_fetch_array($result);
if (!$row) {
	print "<p>Error: No data returned from database.</p>";
	exit();
}

$user_name = $row['firstname'] . " " . $row['lastname'];

/* accept a friend request */
if (!empty($_GET['accept_request'])) {

	$email = mysql_real_escape_string($_GET['accept_request']);

	$query = "UPDATE friendship " .
			 "SET dateconnected = NOW() " .
			 "WHERE friendemail = '{$_SESSION['email']}' " .
			 "AND email = '$email'";

			 $result = mysql_query($query);
	if (!$result) {
		print '<p class="error">Error: ' . mysql_error() . '</p>';
		exit();
	}
	
}

/* reject a friend request */
if (!empty($_GET['reject_request'])) {

	$email = mysql_real_escape_string($_GET['reject_request']);

	$query = "DELETE FROM friendship " .
			 "WHERE dateconnected IS NULL " .
			 "AND friendemail = '{$_SESSION['email']}' " .
			 "AND email = '$email'";

	$result = mysql_query($query);
	if (!$result) {
		print '<p class="error">Error: ' . mysql_error() . '</p>';
		exit();
	}
	
}

/* cancel a friend request */
if (!empty($_GET['cancel_request'])) {

	$email = mysql_real_escape_string($_GET['cancel_request']);

	$query = "DELETE FROM friendship " .
			 "WHERE dateconnected IS NULL " .
			 "AND email = '{$_SESSION['email']}' " .
			 "AND friendemail = '$email'";

	$result = mysql_query($query);
	if (!$result) {
		print '<p class="error">Error: ' . mysql_error() . '</p>';
		exit();
	}
	
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>GTOnline Friend Requests</title>
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
					<li class="selected"><a href="requests.php">requests</a></li>
					<li><a href="logout.php">log out</a></li>              
				</ul>
			</div>
			
			<div class="center_content">
			
				<div class="center_left">
					<div class="title_name"><?php print $user_name; ?></div>          
					
					<div class="features">   
						
						<div class="profile_section">
														
							<div class="subtitle">Friend requests to you</div>
							
							<?php
							
							$query = "SELECT firstname, lastname, hometown, relationship, user.email " .
									 "FROM friendship " .
									 "INNER JOIN regularuser ON regularuser.email = friendship.email " .
									 "INNER JOIN user ON user.email = regularuser.email " .
									 "WHERE friendship.friendemail = '{$_SESSION['email']}' " .
									 "AND dateconnected IS NULL " .
									 "ORDER BY lastname, firstname";
							
							$result = mysql_query($query);
							if (!$result) {
								print '<p class="error">Error: ' . mysql_error() . '</p>';
								exit();
							}	
							
							$row = mysql_fetch_array($result);
							
							if ($row) {
													
								print '<table width="100%">';
								print '<tr>';
								print '<td class="heading">Name</td>';
								print '<td class="heading">Hometown</td>';
								print '<td class="heading">Relationship</td>';
								print '<td class="heading">Accept?</td>';
								print '<td class="heading">Reject?</td>';
								print '</tr>';
							
								while ($row){
														
									print '<tr>';
									print '<td>' . $row['firstname'] . ' ' . $row['lastname'] . '</td>';
									print '<td>' . $row['hometown'] . '</td>';
									print '<td>' . $row['relationship'] . '</td>';
									print '<td><a href="requests.php?accept_request=' . urlencode($row['email']) . '">accept</a></td>';
									print '<td><a href="requests.php?reject_request=' . urlencode($row['email']) . '">reject</a></td>';
									print '</tr>';

									$row = mysql_fetch_array($result);
								
								}
								print '</table>';
							}
							else {
								print "<br/>None!";
							}
							
							?>
							
														
						</div>
						<div class="profile_section">
							
							<br/><br/>
							<div class="subtitle">Friend requests you have sent</div>
							
							<?php
							
							$query = "SELECT firstname, lastname, hometown, relationship, user.email " .
									 "FROM friendship " .
									 "INNER JOIN regularuser ON regularuser.email = friendship.friendemail " .
									 "INNER JOIN user ON user.email = regularuser.email " .
									 "WHERE friendship.email = '{$_SESSION['email']}' " .
									 "AND dateconnected IS NULL " .
									 "ORDER BY lastname, firstname";
							
							$result = mysql_query($query);
							if (!$result) {
								print '<p class="error">Error: ' . mysql_error() . '</p>';
								exit();
							}	
							
							$row = mysql_fetch_array($result);
							
							if ($row) {
													
								print '<table width="100%">';
								print '<tr>';
								print '<td class="heading">Name</td>';
								print '<td class="heading">Hometown</td>';
								print '<td class="heading">Relationship</td>';
								print '<td class="heading">Cancel?</td>';
								print '</tr>';
							
								while ($row){
														
									print '<tr>';
									print '<td>' . $row['firstname'] . ' ' . $row['lastname'] . '</td>';
									print '<td>' . $row['hometown'] . '</td>';
									print '<td>' . $row['relationship'] . '</td>';
									print '<td><a href="requests.php?cancel_request=' . urlencode($row['email']) . '">cancel</a></td>';
									print '</tr>';
									
									$row = mysql_fetch_array($result);
								
								}
								print '</table>';
							}
							else {
								print "<br/>None!";
							}
							
							?>
							
														
						</div>
						
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