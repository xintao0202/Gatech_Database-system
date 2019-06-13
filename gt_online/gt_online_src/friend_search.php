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

unset($result);

/* if form was submitted, then execute query to search for friends */
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$name = mysql_real_escape_string($_POST['name']);
	$email = mysql_real_escape_string($_POST['email']);
	$hometown = mysql_real_escape_string($_POST['hometown']);
		
	$query = "SELECT regularuser.email, firstname, lastname, hometown " .
			 "FROM user " .
			 "INNER JOIN regularuser ON regularuser.email = user.email " .
			 "WHERE regularuser.email NOT IN " .
			 "	(SELECT friendemail FROM friendship WHERE email = '{$_SESSION['email']}') " . 
			 "AND regularuser.email <> '{$_SESSION['email']}'";
			 
	if (!empty($name) or !empty($email) or !empty($hometown)) {
	
		$query = $query . " AND (1=0 ";
		
		if (!empty($name)) {
			$query = $query . " OR firstname LIKE '%$name%' OR lastname LIKE '%$name%' ";
		}
		if (!empty($email)) {
			$query = $query . " OR regularuser.email LIKE '%$email%' ";
		}
		if (!empty($hometown)) {
			$query = $query . " OR hometown LIKE '%$hometown%' ";
		}
		
		$query = $query . ") ";
	}
	
	$query = $query . " ORDER BY lastname, firstname";
	
	//print '<p class="error">Final query = ' . $query . '</p>';
	
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
		<title>GTOnline Friend Search</title>
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
					<li class="selected"><a href="friend_search.php">search for friends</a></li>
					<li><a href="requests.php">requests</a></li>
					<li><a href="logout.php">log out</a></li>              
				</ul>
			</div>
			
			<div class="center_content">
			
				<div class="center_left">
					
					<div class="title_name"><?php print $user_name; ?></div>          
					
										
					<div class="features">   
						
						<div class="profile_section">
							
							<div class="subtitle">Search for Friends</div>    
							
							<form name="searchform" action="friend_search.php" method="post">
							<table width="80%">								
								<tr>
									<td class="item_label">Name</td>
									<td><input type="text" name="name" /></td>
								</tr>
								<tr>
									<td class="item_label">Email</td>
									<td><input type="text" name="email" /></td>
								</tr>
								<tr>
									<td class="item_label">Hometown</td>
									<td><input type="text" name="hometown" /></td>
								</tr>
								
							</table>
							
							<a href="javascript:searchform.submit();" class="fancy_button">search</a> 
							
							</form>
							
														
						</div>
						
						<?php
						if (isset($result)) {
													
							print "<div class='profile_section'>";
							print "<div class='subtitle'>Search Results</div>";							
							print "<table width='80%'>";
							print "<tr><td class='heading'>Name</td><td class='heading'>Hometown</td></tr>";
							
							while ($row = mysql_fetch_array($result)){
								
								$friendemail = urlencode($row['email']);
								
								print "<tr>";
								print "<td><a href='friend_request.php?friendemail=$friendemail'>{$row['firstname']} {$row['lastname']}</a></td>";
								print "<td>{$row['hometown']}</td>";									
								print "</tr>";
								
							}
							
							print "</table>";
							print "</div>";
						
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