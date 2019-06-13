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

/* if form was submitted, then save new data */
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	/* validate form */
	if (is_date($_POST['birthdate'])) {
		$birthdate = $_POST['birthdate'];
	}
	else {
		$birthdate = '';
	}
	
	/* FIX this section - retrieve the hometown field from the 
		$_POST array and escape it with mysql_real_escape_string() */		
	
	$hometown = mysql_real_escape_string($_POST['hometown']);
	$currentcity = mysql_real_escape_string($_POST['currentcity']);
	
	/* FIX this query - add the user's hometown to the UPDATE statement */
	$query = "UPDATE regularuser " .
			 "SET sex='{$_POST['sex']}', " .
			 "birthdate='$birthdate', " .
			 "hometown='$hometown', " .
			 "currentcity='$currentcity' " .
			 "WHERE email='{$_SESSION['email']}'";
	
	if (!mysql_query($query)) {
		print '<p class="error">Error: Failed to update user profile. ' . mysql_error() . '</p>';
	}
	
	/* should we add an interest? */
	if (!empty($_POST['add_interest']) and $_POST['add_interest'] != '(add interest)' and trim($_POST['add_interest']) != '') {
		
		$interest = mysql_real_escape_string($_POST['add_interest']);
		$query = "INSERT INTO userinterests (email, interest) " .
				 "VALUES('{$_SESSION['email']}', '$interest')";
		
		if (!mysql_query($query)) {
			print '<p class="error">Error: Failed to add interest. ' . mysql_error() . '</p>';
		}
	}
}

/* should we delete an interest? */
if (!empty($_GET['delete_interest'])) {
	
	$interest = mysql_real_escape_string($_GET['delete_interest']);
	$query = "DELETE FROM userinterests " .
			 "WHERE email = '{$_SESSION['email']}' " .
			 "AND interest = '$interest'";
	
	if (!mysql_query($query)) {
		print '<p class="error">Error: Failed to delete interest. ' . mysql_error() . '</p>';
	}
}

/* FIX query - add the hometown column to the SELECT clause */
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
	print "<p>Error: No data returned from database.</p>";
	exit();
}

function is_date( $str ) { 
	$stamp = strtotime( $str ); 
	if (!is_numeric($stamp)) { 
		return false; 
	} 
	$month = date( 'm', $stamp ); 
	$day   = date( 'd', $stamp ); 
	$year  = date( 'Y', $stamp ); 
  
	if (checkdate($month, $day, $year)) { 
		return true; 
	} 
	return false; 
} 

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>GTOnline Edit Profile</title>
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
					<li class="selected"><a href="edit_profile.php">edit profile</a></li>
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
							
							<form name="profileform" action="edit_profile.php" method="post">
							<table width="80%">
								<tr>
									<td class="item_label">Sex</td>
									<td>
										<select name="sex">
											<option value="M" <?php if ($row['sex'] == 'M') { print 'selected="true"';} ?>>Male</option>
											<option value="F" <?php if ($row['sex'] == 'F') { print 'selected="true"';} ?>>Female</option> 
										</select>
									</td>
								</tr>
								<tr>
									<td class="item_label">Birthdate</td>
									<td>
										<input type="text" name="birthdate" value="<?php if ($row['birthdate']) { print $row['birthdate']; } ?>" />										
									</td>
								</tr>
								<tr>
									<td class="item_label">Current City</td>
									<td>
										<input type="text" name="currentcity" value="<?php if ($row['currentcity']) { print $row['currentcity']; } ?>" />	
									</td>
								</tr>
								
								<!-- FIX THIS SECTION -->
								<!-- add user's hometown here -->
								<tr>
									<td class="item_label">Hometown</td>
									<td>
										<input type="text" name="hometown" value="<?php if ($row['hometown']) { print $row['hometown']; } ?>" />	
									</td>
								</tr>
								
								<tr>
									<td class="item_label">Interests</td>
									<td>
										<ul>
										<?php
										
										$query = "SELECT interest FROM userinterests WHERE email='{$_SESSION['email']}'";
										$result = mysql_query($query);
										
										while ($row = mysql_fetch_array($result)) {
											print "<li>{$row['interest']} <a href='edit_profile.php?delete_interest=" . 
												urlencode($row['interest']) . "'>delete</a></li>";
										}
										
										?>
										<li><input type="text" name="add_interest" value="(add interest)" 
												onclick="if(this.value=='(add interest)'){this.value=''}"
												onblur="if(this.value==''){this.value='(add interest)'}"/></li>
										</ul>
									</td>
								</tr>
							</table>
							
							<a href="javascript:profileform.submit();" class="fancy_button">save</a> 
							
							</form>
							
							
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