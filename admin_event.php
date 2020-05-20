<?php

include('server.php') ?>
<?php
$review=0;
$status='';
if(isset($_GET['EVENT_ID']))
{ $id=$_GET['EVENT_ID'];
  if(isset($_GET['REVIEW'])){
 $review=$_GET['REVIEW'];
 $sql= "UPDATE EVENTS
SET REVIEW = '$review'
WHERE EVENT_ID = '$id';";

if(mysqli_query($db, $sql))
  	{ 
  $review=$review;
  	}
  	else
  	   echo("Error description: " . mysqli_error($db));
  }
}

  	    
  
$name=$_SESSION['username'];
$sql = "select * from EVENTS 
where EVENT_ID='$id'
;";
$result = mysqli_query($db,$sql);
if($result)
{$r=mysqli_fetch_assoc($result);
  $event_name=$r['EVENT_NAME'];
  $begin=$r['BEGIN_DATE_TIME'];
  $end=$r['END_DATE_TIME'];
  $prizes=$r['PRIZES'];
  $description=$r['DESCRIPTION'];
  $id=$r['EVENT_ID'];
  $path="images/".$id.".jpeg";
  $organiser_id=$r['ORGANISER_ID'];
  $form=$r['REGISTRATION_FORM'];
  $status=$r['STATUS'];
  $review=$r['REVIEW'];
}
else
  	   echo("Error description: " . mysqli_error($db));

if($review==1)
$status='Marked for review';
elseif($review==2)
$status='DELETED';
else
$status='Posted';
$sql = "select INSTITUTE,NAME from ORGANISER 
where ORGANISER_ID='$organiser_id'
;";
$resul = mysqli_query($db,$sql);
if($resul)
{$rr=mysqli_fetch_assoc($resul);
  $institute_name=$rr['INSTITUTE'];
  $organiser_name=$rr['NAME'];
}
else
  	   echo("Error description: " . mysqli_error($db));
?>
<!DOCTYPE HTML>

<html>
	<head>
		<title>Event detail</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<style>
	    body {font-family: Arial, Helvetica, sans-serif;}

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
  position: relative;
  background-color: #fefefe;
  margin: auto;
  padding: 0;
  border: 1px solid #888;
  width: 80%;
  box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
  -webkit-animation-name: animatetop;
  -webkit-animation-duration: 0.4s;
  animation-name: animatetop;
  animation-duration: 0.4s
}

/* Add Animation */
@-webkit-keyframes animatetop {
  from {top:-300px; opacity:0} 
  to {top:0; opacity:1}
}

@keyframes animatetop {
  from {top:-300px; opacity:0}
  to {top:0; opacity:1}
}

/* The Close Button */
.close {
  color: white;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}

.modal-header {
  padding: 2px 16px;
  background-color: #5cb85c;
  color: white;
}

.modal-body {padding: 2px 16px;}

.modal-footer {
  padding: 2px 16px;
  background-color: #5cb85c;
  color: white;
}
	
	    table{font-size:1.8vw;}
	    @media screen and (max-width: 600px) {
  table {
    font-size: 1.8vh;
  }
}
	
	</style>
	<body class="subpage">

		<!-- Header -->
			<header id="header">
				<div class="logo"><a href="admin_homepage.php">Back</a></div>
				<a href="#menu">Menu</a>
			</header>

		<!-- Nav -->
			<nav id="menu">
				<ul class="links">
					<li><a href="admin_homepage.php">Home Page</a></li>
					<li><a href="admin_dashboard.php">Dashboard</a></li>
						<li><a href="admin_dashboard.php#user">User Details</a></li>
					<li><a href="delete.php">Deleted/Marked</a></li>
					<li><a href="logout.php">Logout</a></li>
					
				</ul>
			</nav>

		<!-- One -->
			<section id="One" class="wrapper style3">
				<div class="inner">
					<header class="align-center">
						<p>ORGANISER</p>
						<h2><?php echo($organiser_name); ?></h2>
					</header>
				</div>
			</section>

		<!-- Two -->
			<section id="two" class="wrapper style2">
				<div class="inner">
                                               
					<div class="box">
						<div style="padding:30px;">
                             <?php
						    require_once "pdo.php";
						    $loc = NULL;
						$sql123 = "SELECT * FROM IMAGES  WHERE EVENT_ID = :Data123";
					$stmt123 = $pdo -> prepare($sql123);
					$stmt123 -> execute(array(':Data123' => $_GET['EVENT_ID']));
					$row123 = $stmt123->fetchAll(PDO::FETCH_ASSOC);
					foreach($row123 as $re)
					{$loc = $re['IMAGES'];
					break;}
						    ?>
                            <img src="<?php echo($loc); ?>" style=" max-width:100%; height: auto;display: block;margin-left: auto;margin-right: auto;"/>
							<header class="align-center">
								<p><?php echo($institute_name); ?></p>
								<h2><?php echo($organiser_name); ?> <p> Presents </p><?php echo($event_name); ?></h2>
							
							<h1><br><br>
						    <b>Event Name</b>           :   <br><?php echo($event_name); ?><br><br>
						    <b>Start Date and Time</b>	:	<br><?php echo($begin); ?><br><br>
					        <b>End Date and Time</b> 	:	<br><?php echo($end); ?><br><br>
						    <b>Prizes</b>			 	:	<br><?php echo($prizes); ?><br><br>
						    <b>Description</b>			:	<br><?php echo($description); ?><br><br>
						    <b>STATUS</b>			:	<br><?php echo($status); ?>
						    </h1>
<header class="align-center">
    
    <?php 
        if($review==0 || $review==1)
           echo '	<button class="button special" id="myBtn" style="align:center;">DELETE</button>';
        elseif($review==2)
           echo '	<button class="button special" onclick="document.location = \'admin_event.php?REVIEW=0&EVENT_ID='.$id.' \'" style="align:center;" >RESTORE</button>';
         if($review==0)
           echo '	<button class="button special" onclick="document.location = \'admin_event.php?REVIEW=1&EVENT_ID='.$id.' \'" style="align:center;">Mark for REVIEW</button>';
        elseif($review==1)
           echo '	<button class="button special" onclick="document.location = \'admin_event.php?REVIEW=0&EVENT_ID='.$id.' \'" style="align:center;">Remove Marker</button>';
          
           ?>
			<button class="button special" onclick="document.location = 'admin_comments.php?EVENT_ID=<?php echo($id); ?>&ORGANISER_ID=<?php echo($organiser_id) ?>' " style="align:center;">Comments and Queries</button>
			<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <span class="close">&times;</span>
      <h2>Confirm DELETION ?</h2>
    </div>
    <div class="modal-body">
      <a href="admin_event.php?REVIEW=2&EVENT_ID=<?php echo($id); ?>">YES</a>
      <p> Note - You can also mark for review this post instead of deleting.</p>
    </div>
    <div class="modal-footer">
      <h3>You can restore this post anytime in future.</h3>
    </div>
  </div>

</div>

							</header>

						</div>
					</div>
				</div>
			</section>

 <center><h2>Student Details</h2>
            <p>List of students who have registred for this event.</p></center>
        <div class = 'table wrapper'>
            <table >
            <thead>
                <tr>
                <td><b>Student Name</b></td>
                <td><b>Institute</b></td>
                <td><b>Graduation Year</b></td>
                <td><b>Email ID</b></td>
            </tr>
            </thead><?php
        $sql = "SELECT * FROM USERS JOIN USER_DATA JOIN EVENTS WHERE USERS.USER_ID = USER_DATA.USER_ID AND USER_DATA.EVENT_PARTICIPATING_ID = EVENTS.EVENT_ID AND EVENTS.EVENT_NAME = '$event_name';";
        $result = mysqli_query($db,$sql);
        if($result){
            while($r=mysqli_fetch_assoc($result)){
                 echo('<tr>
                <td>'.$r["NAME"].'</td>
                <td>'.$r["INSTITUTE"].'</td>
                <td>'.$r["GRADUATION_YEAR"].'</td>
                <td>'.$r["EMAIL_ID"].'</td>
            </td></tr>');
            }
        }
        	else
  	   echo("Error description: " . mysqli_error($db));
       
        ?></table>


		<!-- Footer -->
			<footer id="footer">
				<div class="container">
					<ul class="icons">
						<li><a href="https://twitter.com/IIITRanchi" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
						<li><a href="https://www.facebook.com/IIITRanchiOfficial/" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
						<li><a href="https://www.instagram.com/its_iiit_ranchi/" class="icon fa-instagram"><span class="label">Instagram</span></a></li>
						<li><a href="http://iiitranchi.ac.in/" class="icon fa-envelope-o"><span class="label">Email</span></a></li>
					</ul>
				</div>
				<div class="copyright">
					&copy; IIITRANCHI. All rights reserved.
				</div>
			</footer>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>
			<script>
// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>

	</body>
</html>