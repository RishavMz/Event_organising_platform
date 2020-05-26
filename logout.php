<?php 

        //This is the logout file which terminates the session and enables redirection to a fresh login
  session_start(); 

  if (!isset($_SESSION['username'])) {
  	$_SESSION['msg'] = "You must log in first";
  	header('location: login.php');
  }
  if (isset($_GET['logout'])) {
  	session_destroy();
  	unset($_SESSION['username']);
  	if(isset($_SESSION['Organiser_id'])){    
  	    unset($_SESSION['Organiser_id']);       
  	}                                                 
  	header("location: login.php");
  }
?>
<!DOCTYPE HTML>

<html>
	<head>
		<title>Logout</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>

		<!-- Header -->
			<header id="header" class="alt">
				<div class="logo"><a href="http://iiitranchi.ac.in/">by IIITRANCHI <span></span></a></div>
				<a href="#menu">Menu</a>
			</header>

		<!-- Nav -->
			<nav id="menu">
				<ul class="links">
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
				<!--<article>
					<img src="images/slide04.jpg"  alt="" />
                    <div class="inner">
						<header>
							<p>Get details of all sporting events around you!!</p>
							<h2>Sports Events</h2>
						</header>
					</div> -->

				</article>-->
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
	
  	<!-- notification message -->
   <div class="header">
	<h2>Log Out</h2>
</div>
<div class="content">
  	<!-- notification message -->
  	<?php if (isset($_SESSION['success'])) : ?>
      <div class="error success" >
      	<h3>
          <?php 
          	echo $_SESSION['success']; 
          	unset($_SESSION['success']);
          ?>
      	</h3>
      </div>
  	<?php endif ?>

    <!-- logged in user information -->
    <?php  if (isset($_SESSION['username'])) : ?>
    	<p><strong><?php echo $_SESSION['username']; ?></strong>, do you want to LOGOUT?</p>
    	<p> <a href="index.php?logout='1'" style="color: red;">YES</a> </p>
    	
    <?php endif ?>
</div>
 

<br><br><br>

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