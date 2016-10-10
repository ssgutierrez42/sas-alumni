<?php
session_set_cookie_params(0);
session_start();
if(isset($_SESSION['uid'])){
header("location:index.php");
} else {
	if($_GET["id"] == "error"){
		$status = "Wrong username or password.";
		$user = $_GET["user"];
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>SAS Alumni</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Login">
<meta name="author" content="Santiago Gutierrez">

    <!-- Bootstrap -->
    <link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    
    <!-- Custom and Font -->
    <link rel="stylesheet" type="text/css" href="media/css/login.css"></link>
    <link rel='stylesheet' type='text/css' href="http://fonts.googleapis.com/css?family=Lato:300,400">
  
</head>

<body>
<div id="header">
  <h5>SAS Alumni Network</h5>
</div>
<div id="container">
<table align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
  <tr>
   <form name="form1" method="post" action="register.php" onSubmit="if(document.getElementById('myusername').value == '' || document.getElementById('mypassword').value == '') return false;">
    <td>
	  <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
		  <tr>
		   <td colspan="3">
		     <h4>Member Login</h4>
		     <h6><?php echo $status; ?></h6>
		     <h6 class="bumpBottom">BETA testing stage.</h6>
		   </td>
		  </tr>
		  <tr>
		   <td width="100px">Username:</td>
		   <td width="500"><input class="bumpLeft" name="myusername" type="text" id="myusername" value="<?php echo $user; ?>" required></td>
		  </tr>
		  <tr>
		   <td class="bumpTop">Password:</td>
		   <td><input class="bumpLeft bumpTop2" name="mypassword" type="password" id="mypassword" required></td>
		  </tr>
		   <tr>
		   <td>&nbsp;</td>
		   <td>&nbsp;</td>
		   <td><input type="submit" name="Submit" value="Login"></td>
		  </tr>
	  </table>
    </td>
   </form>
  </tr>
</table>
</div>
<div id="footer">
	<p>Created by <a href="http://gutierrezsantiago.com" target="_blank">Santiago Gutierrez</a> (Class of 2015)</p>
</div>
</body>
</html>
