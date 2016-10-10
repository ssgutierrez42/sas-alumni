<?php
require_once 'directory/scripts/db_config.php';

// Connect to server and select databse.
$link = mysql_connect(DB_SERVER, DB_USER, DB_PASSWORD)or die("Cannot connect to database."); 
mysql_select_db(DB_DATABASE)or die("Cannot select proper database.");

// username and password sent from form 
$myusername=$_POST['myusername']; 
$mypassword=$_POST['mypassword']; 

// To protect MySQL injection (more detail about MySQL injection)
$myusername = stripslashes($myusername);
$mypassword = stripslashes($mypassword);
$myusername = mysql_real_escape_string($myusername);
$mypassword = mysql_real_escape_string($mypassword);

//$result = mysql_query("SELECT * FROM ". DB_TABLE_ALUMNI ." WHERE Student_ID = '$myusername'");
$result = mysql_query("SELECT *, CONCAT(First_Name, Last_Name) as First_Last FROM ".DB_TABLE_ALUMNI." WHERE CONCAT(First_Name, Last_Name) = '$myusername'") or die("Cannot query data.");

// Mysql_num_row is counting table row
$count=mysql_num_rows($result);

if($count > 0){
	while ($row = mysql_fetch_array($result)) {
		if($mypassword == $row['Student_ID']){
			session_set_cookie_params(0);
			session_start();
			$_SESSION['uid'] = $myusername . $mypassword . uniqid();
			$_SESSION['username'] = $myusername;
			$_SESSION['data'] = $mypassword;
			mysql_close($link);
			header("location:index.php");
			exit(0);
		}
	}
}

if(empty($myusername)){
	header("location:login.php?id=error");
} else {
	header("location:login.php?id=error&user=" . $myusername);
}

mysql_close($link);
?>