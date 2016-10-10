<?php
session_set_cookie_params(0);
session_start();
if(!isset($_SESSION['uid'])){
header("location:../login.php");
}

$iphone = strpos($_SERVER['HTTP_USER_AGENT'],"iPhone");
$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");
$palmpre = strpos($_SERVER['HTTP_USER_AGENT'],"webOS");
$berry = strpos($_SERVER['HTTP_USER_AGENT'],"BlackBerry");
$ipod = strpos($_SERVER['HTTP_USER_AGENT'],"iPod");

if ($iphone || $android || $palmpre || $ipod || $berry == true) 
{
	if(isset($_GET["filter"])){
		echo "<script>window.location=\"http://gutierrezsantiago.com/sas/alumni/directory/mobile/index.php?filter=". $_GET["filter"] ."\"</script>";
	} else {
	    echo "<script>window.location=\"http://gutierrezsantiago.com/sas/alumni/directory/mobile/\"</script>";
    }
 }
 
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>SAS Family Directory</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="SAS Student Directory">
    <meta name="author" content="Santiago Gutierrez">
    
    <!-- Bootstrap -->
    <link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="media/css/dataTables.bootstrap.css">
    
    <!-- Custom and Font -->
    <link rel="shortcut icon" href="media/icons/directory.ico">
    <link rel="stylesheet" type="text/css" href="media/css/dataSanti.css"></link>
    <link rel='stylesheet' type='text/css' href="http://fonts.googleapis.com/css?family=Lato:300,400">
  
    <!-- jQuery -->
    <script type="text/javascript" charset="utf8" src="media/js/jquery.js"></script>
  
    <!-- DataTables and JS -->
    <script type="text/javascript" charset="utf8" src="media/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf8" src="media/js/dataTables.bootstrap.js"></script>
    
</head> 
<body> 

<script>
$(document).ready(function() {
    var searchTable = $('#student_directory').dataTable( {
        "processing": true,
        "serverSide": true,
        "paging": true,
        "pageLength": 25,
        "pagingType": "full_numbers",
        "scrollX": true,
        "columnDefs": [
            {
                "targets": [ 0 ],
                "visible": false,
                "searchable": false
            },
            {
                "targets": [ 1 ],
                "visible": false,
                "searchable": true
            } 
        ],
        "dom":' <"toolbar"><"search"f><"table"rt><"bottomLeft"l><"bottomRight"p><"clear">',
        "ajax": "scripts/server_processing.php"
    } );
    
    $("div.toolbar").html('<h5 class="titleMain">SAS Family Directory</h5>');
    
    $('#student_directory tbody').on('click', 'tr', function () {
    	var position = searchTable.fnGetPosition(this); // clicked row position
    	var studentId = searchTable.fnGetData(position)[0]; // value of the first hidden column
        //var id = $('td', this).eq(0).text();
        window.open('http://gutierrezsantiago.com/sas/alumni/directory/find.php?id=' + studentId);
    } );
    searchTable.fnFilter('<?php if(isset($_GET["filter"])){ echo $_GET["filter"];} ?>');
} );
</script>
<!--<h5 class="titleMain">SAS Family Directory</h5>-->
<table id="student_directory" cellpadding="0" cellspacing="0" class="table table-striped table-hover table-condensed table-bordered" data-order='[[ 4, "asc" ], [2, "asc"]]' width="100%">
    <thead id="headerTwo">
        <tr>
        	<th>ID</th>
        	<th>StudentID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Campus</th>
            <th>Graduated</th>
            <th>University</th>
            <th>Major</th>
        </tr>
    </thead>
</table>
	
</body> 
</html> 