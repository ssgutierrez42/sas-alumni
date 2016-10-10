<?php
session_set_cookie_params(0);
session_start();
if(!isset($_SESSION['uid'])){
header("location:../../login.php");
}

require_once '../scripts/db_config.php';
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
 $universityAddress = $row['University_Address'];
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

<link rel="shortcut icon" href="../media/icons/find.ico">
<link rel='stylesheet' type='text/css' href="http://fonts.googleapis.com/css?family=Lato:300,300italic,400,700">

<link rel="stylesheet" media="screen and (min-device-width: 530px)" href="../media/css/addLayout" />
<link rel="stylesheet" media="screen and (max-device-width: 530px)" href="../media/css/addLayout-mobile.css" />

</head>

<body>
    <div id="header">
    	<h5>SAS Family Directory</h5>
    </div>
  <div id="container">
  	<div id="welcomeMessage">	
    	<h6>Welcome to the SAS Alumni Network</h6>
    	<p>It seems like you're a first time user. We need to collect some data in order to include you in the SAS directory.</p>
  	</div>
    <div id="entryContainer">
    	<form name="form1" method="post" action="update.php">
    	<p>Please do <b>not</b> continue if this is not correct.</p>
    	<div id="userData" class="clearFix">
        <div id="userTextData">
            <p><b>Name:</b> <?php echo $fullName; ?></p>
            <p><b>Student ID:</b> <?php echo $_SESSION['data']; ?></p>
            <p><b>SAS Campus: </b><?php echo $campus; ?></p>
            <p><b>Class of: </b><?php echo $gradYear; ?></p>
            <p class="bumpTop"><b>Current University</b></p>
            <p class="hint-color">Format:<i>Name, Address</i></p>
            <p class="hint-color">Example: University of Florida,Gainesville,FL,32611</p>
            <p class="warning">You will NOT be able to delete this entry after you submit. <a id="noEditing" href="#">Why?</a></p>
            <dialog id="window">
				<p id="windowText">In order to promote the accuracy of our data, you can only add transfer universities without deleting old records. Please contact us directly to resolve any possible issues.</p>
				<button type="button" id="exit">Exit</button>
			</dialog>
			<input type="text" id="ajax" name="universityParams" list="json-datalist" placeholder="e.g. University of Florida" value="<?php if(!empty($universityAddress)){ echo $university . ','. $universityAddress; } ?>" required>
			<datalist id="json-datalist"></datalist>
  
			<script src="../media/js/datalist-load.js"></script>
			<!--<input id="currentUniversity" type="text" value="<?php echo $university; ?>"  required/>
			<p class="bumpTop"><b>Address of University</b></p>
            <p class="warning">An inaccurate address will result in an inaccurate Alumni Map entry. Please verify with the <a target="_blank" href="../map/">Alumni Map</a>, or Google.</p>
            <input id="address" type="text" value="<?php echo $universityAddress; ?>"  required/>-->
            <p class="bumpTop"><b>Area of Study:</b></p>
            <p class="hint-color">Major can be undecided.</p>
			<input id="major" name="major" type="text" value="<?php echo $major; ?>" required/>
        </div>
        
        <p class="bumpTop"><b>Senior Quote (Optional)</b></p>
        <textarea rows="3" cols="50" id="quote" name="quote" ><?php echo $quote; ?></textarea>
        
       <p class="bumpTop"><b>Accolades (Optional)</b></p>
        <textarea rows="4" cols="50" id="accolades" name="accolades" ><?php echo $accolades; ?></textarea>
        
       <p class="bumpTop"><b>Testimonial (Optional)</b></p>
        <textarea rows="10" cols="50" id="testimonial" name="testimonial" ><?php echo $testimonial; ?></textarea>
        
       <p class="bumpTop"><b>Primary Contact Email</b></p>
       <p class="warning">It is recommended that you do not set a .edu address as your primary method of contact. <a id="noEdu" href="#">Why?</a></p>
            <dialog id="windowEdu">
				<p id="windowText">Most universities cancel .edu emails after four years.</p>
				<button type="button" id="exitEdu">Exit</button>
			</dialog>
        <input id="primaryEmail" name="primaryEmail" type="text" value="<?php echo $email; ?>" required/>
        
        
        <p class="bumpTop"><b>Second Email (Optional)</b></p>
        <input id="secondEmail" name="secondEmail" type="text" />
        
        <p class="bumpTop"><b>What would you like to be contacted for? (Optional)</b></p>
        <input id="contactFor" name="contactFor" type="text" value="<?php echo $contactFor; ?>" placeholder="Contact me for help with..." />
        
        <!--<p class="bumpTop"><b>Please submit a graduation picture. Recommended: 35x35 with cap and gown.</b></p>
        
        <?php echo '<img class="borderOnly" width="135" height="135" alt="Student Image" src="data:image/jpeg;base64,'.base64_encode( $image ).'"/>'; ?>-->
        </div>
        </div>
        <button class="button big-btn" type="submit" name="Submit" value="Update">Update</button>
        <br></br>
    	</form>
    </div>
  </div>
  
  
<script type="text/javascript">
(function() {
   	var dialog = document.getElementById('window');
   	var dialogEdu = document.getElementById('windowEdu');
	document.getElementById('noEdu').onclick = function() {
		dialogEdu.show();
	};
	document.getElementById('noEditing').onclick = function() {
		dialog.show();
	};
	document.getElementById('exit').onclick = function() {
		dialog.close();
	};
	document.getElementById('exitEdu').onclick = function() {
		dialogEdu.close();
	};
})();

</script>
  
</body>
</html>
