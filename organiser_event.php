<?php 
    /*This file contains details about the event organised by an organiser.
        This file also has a comments section for displaying all queries and comments for the particular event.*/
include('server.php'); 
if(isset($_GET['EVENT_ID']))
{ $id=$_GET['EVENT_ID'];
   if(isset($_GET['REVIEW']))
 $review=$_GET['REVIEW'];
    
}
$review=0;
$status='';
$show=0;
$sql= "UPDATE EVENTS
SET REVIEW = '$review'
WHERE EVENT_ID = '$id';";

if(mysqli_query($db, $sql))
  	{ 
  $review=$review;
  	}
  	else
  	   echo("Error description: " . mysqli_error($db));
$sql = "select * from EVENTS 
where EVENT_ID='$id'
;";
$result = mysqli_query($db,$sql);
            // Loads data about a particular event from events table
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
  /*if($review==1)
  $status='Marked for review by ADMIN';
  elseif($review==2)
  $status='DELETED by ADMIN';
  else
  $status='posted';*/
}
else
  	   echo("Error description: " . mysqli_error($db));
$sql = "select INSTITUTE,NAME,USERNAME from ORGANISER 
where ORGANISER_ID='$organiser_id'
;";
$resul = mysqli_query($db,$sql);
        //Loads data about the organiser
if($resul)
{$rr=mysqli_fetch_assoc($resul);
 $username=$rr['USERNAME'];
  $institute_name=$rr['INSTITUTE'];
  $organiser_name=$rr['NAME'];
}
else
  	   echo("Error description: " . mysqli_error($db));
if($username==$_SESSION['username'])
$show=1;
?>
<!DOCTYPE HTML>

<html>
	<head>
		<title><?php echo($event_name) ;?></title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="assets/css/main.css" />
	</head>
	<body class="subpage">

		<!-- Header -->
			<header id="header">
				<div class="logo"><a href="http://iiitranchi.ac.in/">by IIITRANCHI</a></div>
				<a href="#menu">Menu</a>
			</header>

		<!-- Nav -->
			<nav id="menu">
				<ul class="links">
					<li><a href="logout.php">Logout</a></li>
						<li><a href="organiser_homepage.php">Home Page</a></li>
						<li><a href="organiser_dashboard.php">Dashboard</a></li>
							<li><a href="organiser_account.php">My Account</a></li>
								<li><a href="organiser_delete.php">By ADMIN</a></li>
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
						    $loc = 'images/def.jpg';
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
							<?php $ast = NULL;
							if($review == 0){
							    $ast = "Posted";
							}
							else if($review = 1){
							    $ast = "Marked for Review by Admin";
							}
							else{
							    $ast = "Deleted by Admin";
							}?>
							
							
							<h1><br><br>
						    <b>Event Name</b>           :   <br><?php echo($event_name); ?><br><br>
						    <b>Start Date and Time</b>	:	<br><?php echo($begin); ?><br><br>
					        <b>End Date and Time</b> 	:	<br><?php echo($end); ?><br><br>
						    <b>Prizes</b>			 	:	<br><?php echo($prizes); ?><br><br>
						    <b>Description</b>			:	<br><?php echo($description); ?><br><br>
						    <b>Admin Review</b>			:	<br><?php     echo($ast); ?><br><br>
						    <b>STATUS</b>			:	<br><?php echo($status); ?>
						    </h1>
<header class="align-center">
    <?php 
        

        if($review==1)
           echo '	<button class="button special" onclick="document.location = \'organiser_event.php?REVIEW=0&EVENT_ID='.$id.' \'" style="align:center;">Remove Marker</button>';
          
         if($show==1)  
			echo '<button class="button special" onclick="document.location = \'comment_QA.php?EVENT_ID='.$id.'\' " style="align:center;">Comments and Queries</button>' ?>
							
							</header>

						</div>
					</div>
				</div>
			</section>
<h2 style="text-align:center;padding:10px;"><b>Comment Section</b></h2>
<?php
$count=0;
$sql = "select * from COMMENTS_QUERIES 
where EVENT_ID='$id'
;";
$result = mysqli_query($db,$sql);
                //Displays queries for the event
if($result){
     echo ' <div id="main" class="container">
                          <header>
		<ul>';
     while($r=mysqli_fetch_assoc($result)){
          $count+=1;
          $query_id=$r['QUERY_ID'];
          $query=$r['QUERY'];
          $user_name=$r['AUTHOR'];
          echo '<li><h2>'.$query.'</h2>
		          <p>	<t>posted by '.$user_name.'</t></p>';
           $sq = "select * from COMMENTS_ANSWERS 
          where QUERY_ID='$query_id'
           ;";
          $resul = mysqli_query($db,$sq);
                        //Displays answers for the comment
         if($resul){
                echo '<ul style="list-style: none;">';
                while($rr=mysqli_fetch_assoc($resul)){
                        $answer=$rr['ANSWER'];
                        $organiser_name=$rr['AUTHOR'];
                        echo '<li>
                                                         <blockquote>
			              <h3><small>Reply: </small>'.$answer.'</h3> 
			             <p>By '.$organiser_name.'</p>
		                      </blockquote>
		                </li>' ;
                 }
                 echo ' </ul>' ;
          }
          else
  	     echo("Error description: " . mysqli_error($db));
         echo '</li>';
          
       }
       echo '  </ul>
                       </header>
                       <br>
                      </div>' ;
}
else
  	   echo("Error description: " . mysqli_error($db));
if($count==0)
echo '	
						<header class="align-center">
						<p class="special"></p>
						<h2>No Comments posted yet !! <br><br><br></h2>
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