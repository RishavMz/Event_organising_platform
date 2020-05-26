<?php
/*  this page contains details of the user selected and events in which he/she has registered.
    Note- events marked for review or deleted  will be hidden to users.
*/  
include('server.php');

if (isset($_GET['USER_ID'])) {
  	$user_id=$_GET['USER_ID'];
  }

$running=0;
$future=0;
$past=0;
$registered=0;

//to findout number of running events
//only count those events which aren't marked/deleted.
$sql = "select * from EVENTS 
where END_DATE_TIME >= cast((now()) as date) and BEGIN_DATE_TIME <= cast((now()) as date) AND REVIEW = 0;";
$result = mysqli_query($db,$sql);
if($result)
{
    while($r=mysqli_fetch_assoc($result))
    { 
        $running=$running+1;
        
    }
}
	else
  	   echo("Error description: " . mysqli_error($db));
  	   
//to findout number of past events
//only count those events which aren't marked/deleted.  	   
$sql = "select * from EVENTS 
where END_DATE_TIME < cast((now()) as date) AND REVIEW = 0
;";
$result = mysqli_query($db,$sql);
if($result)
{
    while($r=mysqli_fetch_assoc($result))
    {
        $past=$past+1;
        
    }
}
	else
  	   echo("Error description: " . mysqli_error($db));
  	   
//to findout number of future events
//only count those events which aren't marked/deleted.  	   
$sql = "select * from EVENTS 
where BEGIN_DATE_TIME >= cast((now()) as date) AND REVIEW = 0;";
$result = mysqli_query($db,$sql);
if($result)
{
     while($r=mysqli_fetch_assoc($result))
     {
         $future=$future+1;
         
     }
}
	else
  	   echo("Error description: " . mysqli_error($db));
  	   
//to findout number of events for which user registered
//only count those events which aren't marked/deleted.  	   
 $sql = "SELECT * FROM USERS WHERE USER_ID = '$user_id';";
 $result = mysqli_query($db, $sql);
 $user = mysqli_fetch_assoc($result);
  
 if ($user) {
   // if user exists
   $name=$user['USERNAME'];
   $user_id=$user['USER_ID'];
   $fullname=$user['NAME'];
   $institute=$user['INSTITUTE'];
   $grad_year=$user['GRADUATION_YEAR'];
   $email=$user['EMAIL_ID'];
   $phone=$user['PHONE'];
  }
else
  echo("Error description: " . mysqli_error($db));
$sql = "select * from USER_DATA 
where USER_ID = $user_id
;";
$result = mysqli_query($db,$sql);
if($result)
{
    while($r=mysqli_fetch_assoc($result))
    {
        $registered=$registered+1;
        
    }
} 
	else
  	   echo("Error description: " . mysqli_error($db));
  	   
?>
<!DOCTYPE HTML>

<html>
	<head>
		<title>Account</title>
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
  width: 25%;
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
					<li><a href="logout.php">Logout</a></li>
					<li><a href="admin_homepage.php">Home Page</a></li>
				
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
			<!-- One -->
				<section id="One" class="wrapper style3">			
			<div class="inner">
					
				<header class="align-center">
					<p>Username: <?php echo($name) ;?></p>
					<h2><?php echo($fullname) ;?></h2>
					<p>Institute/SChool : <?php echo($institute) ;?><br></p>
					<p>Graduation Year : <?php echo($grad_year) ;?><br></p>
					<p>Contact Details : <?php echo($email) ;?><br><?php echo($phone) ;?></p>
				</header>
				
			</div>
		</section>
			<!-- Two -->
			<section id="two" class="wrapper style3">
				<div class="inner">
					<header class="align-center">
						<p></p>
						<h2>DASHBOARD</h2>
					</header>
					
					
					
					
					
                                                                        <div class="row">
  <div class="column" style="background-color:#aaa;">
    <h2>Running Events</h2>
    <h2> <?php echo $running ;?> </h2>
    
  </div>
  <div class="column" style="background-color:#bbb;">
   
    <h2>Future Events</h2>
    <h2> <?php echo $future ;?> </h2>

  </div>
  <div class="column" style="background-color:#aaa;">
    <h2>Past Events</h2>
    <h2> <?php echo $past ;?></h2>
  </div>
  <div class="column" style="background-color:#bbb;">
    <h2>Registered in</h2>
    <h2> <?php echo $registered ;?> </h2>
  </div>
</div>
				</div>
			</section>

				<header class="align-center">
						<p class="special"><br><br><br></p>
						<h2>REGISTERED EVENTS</h2>
					</header>
<?php

$count=0;
//$name= $_SESSION['username'];

$sql = "select * from USER_DATA 
where USER_ID='$user_id'
;";
$result = mysqli_query($db,$sql);
if($result)
{echo'	<!-- One -->
			<section id="One" class="wrapper style2">
				<div class="inner">
					<div class="grid-style">
';
while($rr=mysqli_fetch_assoc($result))
{ $ID=$rr['EVENT_PARTICIPATING_ID'];
$sql = "select * from EVENTS 
where EVENT_ID = '$ID'
;";
$resul = mysqli_query($db,$sql);
if($resul)
{

while($r=mysqli_fetch_assoc($resul))
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


}
else
  	   echo("Error description: " . mysqli_error($db));
}
echo'
					</div>
				</div>
			</section>';
}
else
  	   echo("Error description: " . mysqli_error($db));
 
if ($count==0)
echo '	
						<header class="align-center">
						<p class="special"></p>
						<h2>haven\'t participated in any event !! <br><br><br></h2>
					</header>
						
					';
?>


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