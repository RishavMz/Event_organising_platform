<?php 
/* This file contains the page for details of the event selected.
    The user can register for the event here.
    The user can post queries/comments for the event.
*/   
include('server.php');
?>
<?php
$err=0;
$register=0;

if(isset($_GET['EVENT_ID']))
{
    $id=$_GET['EVENT_ID'];
    if(isset($_GET['ERRORS']))
        $err=$_GET['ERRORS'];
    if(isset($_GET['REGISTER']))
        $register=$_GET['REGISTER'];
    
}

$name=$_SESSION['username'];
//select details of the user from users table
$sql = "SELECT * FROM USERS WHERE USERNAME = '$name';";
$result = mysqli_query($db, $sql);
$user = mysqli_fetch_assoc($result);
  
if ($user) 
{ 
    // if user exists
    $user_id=$user['USER_ID'];}
else
   echo("Error description: " . mysqli_error($db));

//check if user has already registered for the event or not 
$user_check_query = "SELECT * FROM USER_DATA WHERE USER_ID='$user_id' AND EVENT_PARTICIPATING_ID='$id' LIMIT 1";
$result = mysqli_query($db, $user_check_query);
$user = mysqli_fetch_assoc($result);
if ($user)
{    // if user exists
    if ($user['USER_ID'] == $user_id) 
    {
      $register=2;
    }
    else
       $register=1;
} 
 
if($register==1)
{
    	$query = "INSERT INTO USER_DATA (USER_ID, EVENT_PARTICIPATING_ID) 
  			  VALUES('$user_id', '$id')";
  	    if(mysqli_query($db, $query))
      	{ 
      	    $register=2;
  	  	    $query = "UPDATE EVENTS
            SET REGISTRATIONS=REGISTRATIONS+1
            WHERE EVENT_ID = '$id';";
  	        if(mysqli_query($db, $query))
  	        {
  	            $register=2;
  	        }
  	        else{
  	            echo("Error description: " . mysqli_error($db));
  	        }
  	    
  	    }
  	    else
  	    {
  	     echo("Error description: " . mysqli_error($db));
  	     $register=0;
  	    }
}

//select event details from events table
$sql = "select * from EVENTS 
where EVENT_ID='$id' AND REVIEW = 0;";
$result = mysqli_query($db,$sql);
if($result)
{  
  $r=mysqli_fetch_assoc($result);
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
}
else
  	   echo("Error description: " . mysqli_error($db));

//select organiser details from organiser table
$sql = "select INSTITUTE,NAME from ORGANISER 
where ORGANISER_ID='$organiser_id';";
$resul = mysqli_query($db,$sql);
if($resul)
{
  $rr=mysqli_fetch_assoc($resul);
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
	</style>
	<body class="subpage">

		<!-- Header -->
			<header id="header">
				<div class="logo"><a href="http://iiitranchi.ac.in/">by IIITR</a></div>
				<a href="#menu">Menu</a>
			</header>

		<!-- Nav -->
			<nav id="menu">
				<ul class="links">
					<li><a href="user_homepage.php">Home</a></li>
					<li><a href="user_account.php">Your Account</a></li>
					<li><a href="logout.php">Log Out</a></li>
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
							
							<h1><br><br>
						    <b>Event Name</b>           :   <br><?php echo($event_name); ?><br><br>
						    <b>Start Date and Time</b>	:	<br><?php echo($begin); ?><br><br>
					        <b>End Date and Time</b> 	:	<br><?php echo($end); ?><br><br>
						    <b>Prizes</b>			 	:	<br><?php echo($prizes); ?><br><br>
						    <b>Description</b>			:	<br><?php echo($description); ?><br><br>
						    </h1>
<header class="align-center">
    
    <?php if($status=='PAST')
           echo '	<button class="button special" style="align:center;" disabled> REGISTERATION CLOSED</button>';
           elseif($status=='FUTURE')
            echo '	<button class="button special" style="align:center;" disabled>REGISTERATION NOT OPENED YET</button>';
          else{
        if($register==0)
           echo '	<button class="button special" id="myBtn" style="align:center;">REGISTER</button>';
           elseif($register==2)
           echo '	<button class="button special" style="align:center;" disabled>REGISTERED</button>';
          }
           ?>
		
			<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <span class="close">&times;</span>
      <h2>Confirm Registration ?</h2>
    </div>
    <div class="modal-body">
      <a href="user_event.php?REGISTER=1&EVENT_ID=<?php echo($id); ?>">YES</a>
      <p> Note - your signup details will be used for the registration.</p>
    </div>
    <div class="modal-footer">
      <h3>You'll soon recieve a confirmation at email specified during signup.</h3>
    </div>
  </div>

</div>

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


<section id="two" class="wrapper style2">
				<div class="inner">
                                               
					<div class="box">
						<div class="content">
<!-- Form -->
   <h3>Post Comment</h3>
   <?php if($err==1)
       echo '<h4 style="color:red;">Fill all required details !!</h4>';
       ?>
 

  <form method="post" action="server.php">
      	<?php include('errors.php'); ?>
         <div class="row uniform">
	<div class="6u 12u$(xsmall)">
	          <input type="text" name="name" id="name" value="" placeholder="Name" />
	</div>
	<div class="6u$ 12u$(xsmall)">
	         <input type="email" name="email" id="email" value="" placeholder="Email" />
	</div>
	<div class="6u$ 12u$(small)">
	        <input type="checkbox" id="human" name="human" checked>
	        <label for="human">I am a human and not a robot</label>
	        <input type="hidden" value='<?php echo($id); ?>' name="event_id"  >
	</div>
	<!-- Break -->
	<div class="12u$">
	       <textarea name="message" id="message" placeholder="Enter your message" rows="6"></textarea>
	</div>
	<!-- Break -->
	<div class="12u$">
	       <ul class="actions">
		<li><input type="submit" name="comment" value="Send Message" /></li>
	        </ul>
	</div>
       </div>
</form>

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
<!--
                                             Authors
        Rishav Mazumdar ( 2019UGEC013R )                Tushar Jain ( 2019UGCS001R )
-->   