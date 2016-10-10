<?php
session_set_cookie_params(0);
session_start();

require_once '../scripts/db_config.php';
$con=mysqli_connect(DB_SERVER,DB_USER,DB_PASSWORD,DB_DATABASE);
// Check connection
if (mysqli_connect_errno())
{
echo "Failed to connect to MySQL:  mysqli_connect_error()";
}

$universityParams = htmlspecialchars($_POST['universityParams'], ENT_QUOTES, 'UTF-8');
$university = substr($universityParams, 0, strpos($universityParams, ","));
$address = substr($universityParams, strpos($universityParams, ",") + 1);
$major = htmlspecialchars($_POST['major'], ENT_QUOTES, 'UTF-8');
$quote = htmlspecialchars($_POST['quote'], ENT_QUOTES, 'UTF-8');
$accolades = htmlspecialchars($_POST['accolades'], ENT_QUOTES, 'UTF-8');
$testimonial = htmlspecialchars($_POST['testimonial'], ENT_QUOTES, 'UTF-8');
$email = htmlspecialchars($_POST['primaryEmail'], ENT_QUOTES, 'UTF-8');
$secondaryEmail = htmlspecialchars($_POST['secondEmail'], ENT_QUOTES, 'UTF-8');
$contactFor = htmlspecialchars($_POST['contactFor'], ENT_QUOTES, 'UTF-8');

$sql = "UPDATE alumni SET University='$university',University_Address='$address',Major='$major',Senior_Quote='$quote',Accolades='$accolades',Testimonial='$testimonial',Contact_Email='$email',Second_Email='$secondaryEmail',Contact_For='$contactFor' WHERE Student_ID=" . $_SESSION['data'];

if (mysqli_query($con, $sql)) {
    echo "Record updated successfully";
    header("location:index.php?success=true");
} else {
    echo "Unable to update data. Please press the back button on your browser if you wish to try again. Error message:" . $con->error;
}

mysqli_close($con);
?>