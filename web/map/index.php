<?php
session_set_cookie_params(0);
session_start();
if(!isset($_SESSION['uid'])){
	header("location:../login.php");
}

require_once '../directory/scripts/db_config.php';// Connect to server and select databse.
$link = mysql_connect(DB_SERVER, DB_USER, DB_PASSWORD)or die("Cannot connect to database."); 
mysql_select_db(DB_DATABASE)or die("Cannot select proper database.");

$result = mysql_query("SELECT * FROM " . DB_TABLE_ALUMNI) or die("Cannot select alumni");
$addresses = array(); //will actually store how many times address appears
$names = array(); //will store name of universities
$studentData = array(); //will store name of students that attend a certain university.

if (mysql_num_rows($result) > 0) {
    while ($row = mysql_fetch_array($result)) {
    	$firstVal = $row["First_Name"]; //start getting fields from MySQL
    	$lastVal = $row["Last_Name"];
    	$gradYearVal = $row["Graduation_Year"];
    	$dirVal = $row["University_Address"];
    	$uniName = $row["University"];
    	if(!empty($dirVal)){ //If there's an address for the current user
	    	$addresses[$dirVal] = $addresses[$dirVal] + 1; //add on to the count
	    	
	    	//add student name information to array, limit to 20 per school
	    	if($addresses[$dirVal] <= 20){
	    		if($studentData[$dirVal] != null) //prepare to comma separate values
	    			$studentData[$dirVal] = $studentData[$dirVal] . ", ";
	    			
	    		$formatData = $firstVal . " " . $lastVal . " (" . $gradYearVal . ")";
	    		$studentData[$dirVal] = $studentData[$dirVal] . $formatData; //store student data	    	
	    	}
	    	
	    	if($names[$dirVal] == null)
	        	$names[$dirVal] = $uniName; //add name to the list
    	}
 
    }
}

$count = count($addresses); //will store how many universities were found

$keys = array_keys($addresses); // will store the address of universities
$addresses = array_values($addresses); // will store how many times an address appears (LINEAR)
$names = array_values($names); //will store name of universities (LINEAR)
$studentData = array_values($studentData); //will store comma-separated student data (LINAER)

mysql_close($link);
?>
<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
	<title>SAS Alumni Map</title>
	<meta name="description" content="Map">
	<meta name="author" content="Santiago Gutierrez">
    <meta charset="utf-8">
    <link rel="shortcut icon" href="media/icons/map.ico">
    <link rel="stylesheet" type="text/css" href="media/css/mapLayout.css"></link>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>
    <script src="media/js/markerwithlabel.js" type="text/javascript"></script>
    <script>

var universities = {};
var keys = <?php echo json_encode($keys); ?>; //ACTUAL addresses
var values = <?php echo json_encode($addresses); ?>; //how many times an address appears
var names = <?php echo json_encode($names); ?>; // name of universities
var students = <?php echo json_encode($studentData); ?>; // name of some students

for(var i = 0; i < <?php echo $count; ?>; i++){
	universities[keys[i]] = {
		name: names[i],
		count: values[i],
		students: students[i]
	}
}

var infowindow;
var geocoder;

function initialize() {
  var mapOptions = {
    zoom: 4,
    center: new google.maps.LatLng(37.09024, -95.712891),
    mapTypeId: google.maps.MapTypeId.ROADMAP
  };

  var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
  
  infowindow = new google.maps.InfoWindow();
  geocoder = new google.maps.Geocoder();
  
  for(var address in universities){
	  codeAddressWithMarker(map, address, universities[address].name, universities[address].count, universities[address].students);
  }
}

 function codeAddressWithMarker(map, userAddress, uniName, uniCount, uniStudents) {
  var address = userAddress;
  geocoder.geocode( { 'address': address}, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
      var marker = new MarkerWithLabel({
       position: results[0].geometry.location,
       map: map,
       animation: google.maps.Animation.DROP,
       title: uniName,
       labelContent: uniCount,
       labelAnchor: new google.maps.Point(10, 0),
       labelClass: "labels", // the CSS class for the label
       labelStyle: {opacity: 0.75}
     });
	  createClickableObject(map, marker, userAddress, uniName, uniCount, uniStudents); 
    } else {
      alert('Geocoding ' + uniName + ' at ' + uniAddress + ' was not successful for the following reason: ' + status);
    }
  });
}

function createClickableObject(map, marker, userAddress, uniName, uniCount, uniStudents){ 
    google.maps.event.addListener(marker, 'click', function(event) {
      var contentString = '<div id="content">'+
      '<div id="siteNotice">'+
      '</div>'+
      '<h1 id="firstHeading" class="firstHeading">'+ uniName +'</h1>'+
      '<div id="bodyContent">'+
      '<p><b>Located in: </b>'+ userAddress +'</p>'+
      '<p>SAS alumni count at this institution: '+ uniCount +'</p>' +
      //'<p><b>Some students include: </b>'+ uniStudents +'</p>' +
      '<p><a href="http://gutierrezsantiago.com/sas/alumni/directory/index.php?filter='+ uniName +'" target="_blank">'+
      'Click here to view all '+ uniName +' SAS alumni</a></p>'+
      '</div>'+
      '</div>'
         infowindow.setContent(contentString);
         infowindow.open(map, marker);
     });
 }
 
google.maps.event.addDomListener(window, 'load', initialize);
    </script>
  </head>
  <body>
  	<!--<div id="header">
	  	<h5>SAS Alumni Network</h5>
	</div>-->
    <div id="map-canvas"></div>
  </body>
</html>