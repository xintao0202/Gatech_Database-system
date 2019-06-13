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

/* FIX this query - add the column 'hometown' to the SELECT clause */
$query = "SELECT firstname, lastname, sex, birthdate, currentcity, hometown " .
		 "FROM user " .
		 "INNER JOIN regularuser ON user.email = regularuser.email " .
		 "WHERE user.email = '{$_SESSION['email']}'";

$result = mysql_query($query);
if (!$result) {
	print "<p class='error'>Error: " . mysql_error() . "</p>";
	exit();
}

$row = mysql_fetch_array($result);

if (!$row) {
	print "<p>Error: No data returned from database.  Administrator login NOT supported.</p>";
	print "<a href='logout.php'>Logout</a>";
	exit();
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>GTOnline Profile</title>
		<link rel="stylesheet" type="text/css" href="style.css" />
	</head>
	
	<body>

		<div id="main_container">
			
			<div id="header">
				<div class="logo"><img src="images/gtonline_logo.gif" border="0" alt="" title="" /></div>       
			</div>
			
			<div class="menu">
				<ul>                                                                         
					<li class="selected"><a href="profile.php">view profile</a></li>
					<li><a href="edit_profile.php">edit profile</a></li>
					<li><a href="view_friends.php">view friends</a></li>
					<li><a href="friend_search.php">search for friends</a></li>
					<li><a href="requests.php">requests</a></li>
					<li><a href="logout.php">log out</a></li>              
				</ul>
			</div>
			
			<div class="center_content">
			
				<div class="center_left">
					<div class="title_name"><?php print $row['firstname'] . ' ' . $row['lastname']; ?></div>          
					
					<div class="features">   
						
						<div class="profile_section">
							
							<table width="80%">
								<tr>
									<td class="item_label">Sex</td>
									<td><?php if ($row['sex'] == 'M') { print 'Male';} else {print 'Female';} ?></td>
								</tr>
								<tr>
									<td class="item_label">Birthdate</td>
									<td><?php print $row['birthdate'];?></td>
								</tr>
								<tr>
									<td class="item_label">Current City</td>
									<td><?php print $row['currentcity'];?></td>
								</tr>
								<!-- FIX THIS SECTION -->
								<!-- add user's hometown here -->
								<tr>
									<td class="item_label">Hometown</td>
									<td><?php print $row['hometown'];?></td>
								</tr>
								
								<tr>
									<td class="item_label">Interests</td>
									<td>
										<ul>
										<?php
										
										$query = "SELECT interest FROM userinterests WHERE email='{$_SESSION['email']}'";
										$result = mysql_query($query);
										
										while ($row = mysql_fetch_array($result)){
											print "<li>{$row['interest']}</li>";
										}
										
										?>
										</ul>
									</td>
								</tr>
							</table>						
							
						</div>
						
						<!-- FIX THIS SECTION -->
						<!-- add code to show the user's education information -->
						
						<div class="profile_section">
							
							<div class="subtitle">Education</div>  
							
							<table width="80%">
								<tr>
									<td class="heading">School</td>
									<td class="heading">Year Graduated</td>
								</tr>							
						
								<?php
									$query = "SELECT schoolname, yeargraduated " . 
											 "FROM attend " .
											 "WHERE email = '" . $_SESSION['email'] . "' " .
											 "ORDER BY yeargraduated DESC";
									$result = mysql_query($query);
									
									while ($row = mysql_fetch_array($result)) {
										print "<tr>";
										print "<td>" . $row['schoolname'] . "</td>";
										print "<td>" . $row['yeargraduated'] . "</td>";
										print "</tr>";
									}
								?>
							
							</table>
						
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