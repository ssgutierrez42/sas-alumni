<?php
session_set_cookie_params(0);
session_start();
if(!isset($_SESSION['uid'])){
header("location:../login.php");
}

require_once 'scripts/db_config.php';
$con=mysqli_connect(DB_SERVER,DB_USER,DB_PASSWORD,DB_DATABASE);
// Check connection
if (mysqli_connect_errno())
{
echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$result = mysqli_query($con,"SELECT * FROM alumni WHERE id=" . $_GET["id"]);

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

mysqli_close($con);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>SAS Family Directory</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="SAS Student Directory">
<meta name="author" content="Santiago Gutierrez">

<link rel="shortcut icon" href="media/icons/find.ico">
<link rel='stylesheet' type='text/css' href="http://fonts.googleapis.com/css?family=Lato:300,300italic,400,700">

<link rel="stylesheet" media="screen and (min-device-width: 530px)" href="media/css/findLayout.css" />
<link rel="stylesheet" media="screen and (max-device-width: 530px)" href="media/css/findLayout-mobile.css" />

</head>

<body>
    <div id="header">
    	<h5>SAS Family Directory</h5>
    </div>
  <div id="container">
    <div id="entryContainer">
    	<div id="userData" class="clearFix">
        <?php echo '<img class="floatImage borderOnly" width="135" height="135" alt="Student Image" src="data:image/jpeg;base64,'.base64_encode( $image ).'"/>'; ?>
        <div id="userTextData" class="floatLeft">
        	<h6>Full Name</h6>
            <p><?php echo $fullName; ?></p>
            <h6 class="bumpTop">Latest University</h6>
            <p><?php echo $university; ?></p>
            <h6 class="bumpTop">Area of Study</h6>
            <p><?php echo $major; ?></p>
        </div>
        <div id="userTextDataTwo">
        	<h6>SAS Campus</h6>
            <p><?php echo $campus; ?></p>
            <h6 class="bumpTop">Graduation Year</h6>
            <p>Class of <?php echo $gradYear; ?></p>
            <h6 class="bumpTop">Member Type</h6>
            <p><?php echo $type; ?></p>
        </div>
        <p id="userQuote" class="clearLeft"><?php echo $quote; ?></p>
        <div class="bumpTopPadding">
        <h6>Accolades</h6>
        <p><?php echo $accolades; ?></p>
        </div>
        <div class="bumpTop2">
        <h6>Testimonial</h6>
        <p><?php echo $testimonial; ?></p>
        </div>
        <div class="bumpTop2">
        <h6>Contact Information</h6>
        <p><?php echo $contactFor; ?></p>
        <p>Email: <a href="mailto:<?php echo $email; ?>?Subject=SAS%20Alumni%20Contact" target="_top"><?php echo $email; ?></a></p>
        </div>
        </div>
    </div>
  </div>
</body>
</html>
