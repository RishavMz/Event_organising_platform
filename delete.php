<?php 
/*  this page contains details of the events marked for review or deleted by admin.
*/
include('server.php'); 
  

  if (!isset($_SESSION['username'])) {
  	$_SESSION['msg'] = "You must log in first";
  	header('location: login.php');
  }
  if (isset($_GET['logout'])) {
  	session_destroy();
  	unset($_SESSION['username']);
  	header("location: login.php");
  }
?>
<?php

$name= $_SESSION['username'];

$total=0;
$deleted=0;
$rev=0;

//count all events
$sql = "select * from EVENTS 
;";
$result = mysqli_query($db,$sql);
if($result)
{
    while($r=mysqli_fetch_assoc($result))
    {
        $total=$total+1;
        
    }
}
	else
  	   echo("Error description: " . mysqli_error($db));
  	   
//to findout number of deleted events
$sql = "select * from EVENTS 
where REVIEW=2
;";
$result = mysqli_query($db,$sql);
if($result)
{
     while($r=mysqli_fetch_assoc($result))
     { 
         $deleted=$deleted+1;
         
     }
}
	else
  	   echo("Error description: " . mysqli_error($db));
  	   
//to findout number of marked events  	   
$sql = "select * from EVENTS 
where REVIEW=1
;";
$result = mysqli_query($db,$sql);
if($result)
{
      while($r=mysqli_fetch_assoc($result))
      {
          $rev=$rev+1;
          
      }
}
	else
  	   echo("Error description: " . mysqli_error($db));

?>
<!DOCTYPE HTML>

<html>
	<head>
		<title>Marked/Deleted</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="assets/css/main.css" />
	</head>
           <style>
* {
  box-sizing: border-box;
}

/* Create two equal columns that floats next to each other */
.column {
  float: left;
  width: 33.33333%;
  padding: 10px;
  height: 100px; /* Should be removed. Only for demonstration */
 text-align: center;
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}

/* Responsive layout - makes the two columns stack on top of each other instead of next to each other */
@media screen and (max-width: 600px) {
  .column {
    width: 100%;
  }
}
</style>
	<body>

		<!-- Header -->
			<header id="header" class="alt">
				<div class="logo"><a href="http://iiitranchi.ac.in/"> by IIITRANCHI<span></span></a></div>
				<a href="#menu">MENU</a>
			</header>

		<!-- Nav -->
			<nav id="menu">
				<ul class="links">
				    <li><a href="admin_homepage.php">Home Page</a></li>
					<li><a href="admin_dashboard.php">Dashboard</a></li>
					<li><a href="logout.php">Logout</a></li>
					
				
				</ul>
			</nav>

			<!-- Banner -->
			<section class="banner full">
				<article>
					<img src="images/code.jpg" alt="" />
					<div class="inner">
						<header >
						    <p style="font-size:2vw;"> All types of coding events at one place. </p>
							
							<h1 style="font-size:8vw;"> Coding Events </h1>
						</header>
					</div>
				</article>
				<article>
					<img src="images/art.jpg" alt="" />
					<div class="inner">
						<header>
							<p style="font-size:2vw;">Try your skills here </p>
							<h3 style="font-size:8vw;">Art Events </h3>
						</header>
					</div>
				</article>
				<article>
					<img src="images/sports.jpg"  alt="" />
					<div class="inner">
						<header>
							<p style="font-size:2vw;">Get details of all sporting events around you!!</p>
							<h3 style="font-size:8vw;">Sports Events</h3>
						</header>
					</div>
				</article>
				
				<article>
					<img src="images/slide05.jpg"  alt="" />
					<div class="inner">
						<header>
								<p style="font-size:2vw;">Host your event here . Get registered with us as organiser.</p>
							<h3 style="font-size:4vw;">And many more types of events.<br> Stay Connected</h3>
							
						</header>
					</div>
				</article>
			</section>
			<br>
			<br>
			<!-- Two -->
			<section id="two" class="wrapper style3">
				<div class="inner">
					<header class="align-center">
						<p>Summary</p>
						<h2>Events Details</h2>
					</header>
                                                                        <div class="row">
  <div class="column" style="background-color:#aaa;">
    <h2>Total</h2>
    <h2> <?php echo $total ;?> </h2>
    
  </div>
  <div class="column" style="background-color:#bbb;">
   
    <h2>Deleted</h2>
    <h2> <?php echo $deleted ;?> </h2>

  </div>
  <div class="column" style="background-color:#aaa;">
    <h2>Marked</h2>
    <h2> <?php echo $rev ;?></h2>
  </div>
 
</div>
				</div>
			</section>

				<header class="align-center">
						<p class="special"><br><br><br>All the deleted events by ADMIN will be visible here</p>
						<h2>DELETED EVENTS LIST</h2>
					</header>
<?php

$sql = "select * from EVENTS 
where  REVIEW=2
;";
$result = mysqli_query($db,$sql);
if($result)
{echo'	<!-- One -->
			<section id="one" class="wrapper style2">
				<div class="inner">
					<div class="grid-style">
';

while($r=mysqli_fetch_assoc($result))
{ 
  $event_name=$r['EVENT_NAME'];
  $begin=$r['BEGIN_DATE_TIME'];
  $end=$r['END_DATE_TIME'];
  $prizes=$r['PRIZES'];
  $description=$r['DESCRIPTION'];
  $id=$r['EVENT_ID'];
  $path="images/".$id.".jpeg";
    echo ('<div>
							<div class="box">
								<div class="image fit">');
								
						    require_once "pdo.php";
						    $loc = 'images/def.jpg';
						$sql123 = "SELECT * FROM IMAGES  WHERE EVENT_ID = :Data123";
					$stmt123 = $pdo -> prepare($sql123);
					$stmt123 -> execute(array(':Data123' => $id));
					$row123 = $stmt123->fetchAll(PDO::FETCH_ASSOC);
					foreach($row123 as $re)
					{$loc = $re['IMAGES'];
					break;}
						   echo '
								<img src="'.$loc.'"  style=" max-width:100%; max-height:350px;" />
								</div>
								<div class="content">
									<header class="align-center">
										<p>IIIT Ranchi</p>
										<h2>'.$event_name.'</h2>
									</header>
									<p>Start Date:'.$begin.'<br>End Date:'.$end.'<br>Prizes:'.$prizes.'</p>
									<footer class="align-center">
										<a href="admin_event.php?EVENT_ID='.$id.'"class="button alt">Learn More</a>
									</footer>
								</div>
							</div>
						</div>
						';
}
echo'
					</div>
				</div>
			</section>';
}
else
  	   echo("Error description: " . mysqli_error($db));
?>

<!-- PAST EVENTS-->

	<header class="align-center">
						<p class="special"><br><br><br>All the events marked for review by ADMIN will be visible here</p>
						<h2>MARKED FOR REVIEW</h2>
					</header>
<?php

$sql = "select * from EVENTS 
where REVIEW = 1
;";
$result = mysqli_query($db,$sql);
$count=0;
if($result)
{echo'	<!-- One -->
			<section id="one" class="wrapper style2">
				<div class="inner">
					<div class="grid-style">
';

while($r=mysqli_fetch_assoc($result))
{ $count+=1;
  $event_name=$r['EVENT_NAME'];
  $begin=$r['BEGIN_DATE_TIME'];
  $end=$r['END_DATE_TIME'];
  $prizes=$r['PRIZES'];
  $description=$r['DESCRIPTION'];
  $id=$r['EVENT_ID'];
  $path="images/".$id.".jpeg";
   echo ('<div>
							<div class="box">
								<div class="image fit">');
								
						    require_once "pdo.php";
						    $loc = 'images/def.jpg';
						$sql123 = "SELECT * FROM IMAGES  WHERE EVENT_ID = :Data123";
					$stmt123 = $pdo -> prepare($sql123);
					$stmt123 -> execute(array(':Data123' => $id));
					$row123 = $stmt123->fetchAll(PDO::FETCH_ASSOC);
					foreach($row123 as $re)
					{$loc = $re['IMAGES'];
					break;}
						   echo '
								<img src="'.$loc.'"  style=" max-width:100%; max-height:350px;" />
								</div>
								<div class="content">
									<header class="align-center">
										<p>IIIT Ranchi</p>
										<h2>'.$event_name.'</h2>
									</header>
									<p>Start Date:'.$begin.'<br>End Date:'.$end.'<br>Prizes:'.$prizes.'</p>
									<footer class="align-center">
										<a href="admin_event.php?EVENT_ID='.$id.'"class="button alt">Learn More</a>
									</footer>
								</div>
							</div>
						</div>
						';
}
echo'
					</div>
				</div>
			</section>';

}
else
  	   echo("Error description: " . mysqli_error($db));
?>
		
		
		<!-- Three -->
			<section id="three" class="wrapper style2">
				<div class="inner">
					<header class="align-center">
						<p class="special">Connect with us to host your event with us.</p>
						<h2>OUR PARTNERS</h2>
					</header>
					<div class="gallery">
						<div>
							<div class="image fit">
								<a href="https://www.facebook.com/CuLAriti/"><img src="images/partner1.jpg" alt="" /></a>
							</div>
						</div>
						<div>
							<div class="image fit">
								<a href="https://www.facebook.com/unmukt.iiitr/"><img src="images/partner2.jpg" alt="" /></a>
							</div>
						</div>
						<div>
							<div class="image fit">
								<a href="https://www.facebook.com/hG.iiitranchi/"><img src="images/partner3.jpeg" alt="" /></a>
							</div>
						</div>
						<div>
							<div class="image fit">
								<a href="https://www.facebook.com/VYANGIIITR/"><img src="images/partner4.png" alt="" /></a>
							</div>
						</div>
						<div>
							<div class="image fit">
								<a href="http://iiitranchi.ac.in/"><img src="images/partner5.jpeg" alt="" /></a>
							</div>
						</div>
						<div>
							<div class="image fit">
								<a href="https://www.instagram.com/sportscouncil.iiitr/"><img src="images/partner6.jpeg" alt="" /></a>
							</div>
						</div>
					</div>
				</div>
			</section>


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

	</body>
</html>
<!--
                                             Authors
        Rishav Mazumdar ( 2019UGEC013R )                Tushar Jain ( 2019UGCS001R )
-->  