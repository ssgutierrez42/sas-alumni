<?php
session_set_cookie_params(0);
session_start();
if(!isset($_SESSION['uid'])){
header("location:login.php");
}

require_once 'directory/scripts/db_config.php';
$con=mysqli_connect(DB_SERVER,DB_USER,DB_PASSWORD,DB_DATABASE);
// Check connection
if (mysqli_connect_errno())
{
echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$result = mysqli_query($con,"SELECT * FROM alumni WHERE Student_ID=" . $_SESSION['data']);

while($row = mysqli_fetch_array($result))
{
 $fullName = $row['First_Name'] ." ". $row['Last_Name'];
 $university = $row['University'];
 $major = $row['Major'];
 $gradYear = $row['Graduation_Year'];
 $campus = $row['Campus'];
 $type = $row['Type'];
 $quote = $row['Senior_Quote'];
 $accolades = $row['Accolades'];
 $testimonial = $row['Testimonial'];
 $contactFor = $row['Contact_For'];
 $email = $row['Contact_Email'];
 $image = $row['Yearbook_Image'];
}


/*if(empty($university) && intval($gradYear)<=intval(date("Y"))){ //force create new account
header("location:directory/data/add.php");
}*/

mysqli_close($con);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>SAS Alumni</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Login">
<meta name="author" content="Santiago Gutierrez">

 <!-- Custom and Font -->
 <link rel="stylesheet" type="text/css" href="media/css/index.css"></link>
 <link rel='stylesheet' type='text/css' href="http://fonts.googleapis.com/css?family=Lato:300,400">

</head>

<body>
<div id="header">
  <h5>SAS Alumni Network</h5>
</div>
<div id="container">
	<a href="directory">SAS Directory</a>
	<br></br>
	<a href="map">SAS Alumni Map</a>
	<br></br>
	<?php
	if(empty($university) && intval($gradYear)<=intval(date("Y"))){ 
		echo '<a href="directory/data/add.php">Create Profile</a>';
	} else {
		echo 'Create Profile (unavailable)';
	}
	?>
	<br></br>
	<a href="logout.php">Log Out</a>
</div>
</body>
</html>
