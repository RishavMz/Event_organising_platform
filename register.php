<?php include('server.php') ?>
<!DOCTYPE HTML>

<html>
	<head>
		<title>Sign up</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>

		<!-- Header -->
			<header id="header" class="alt">
				<div class="logo"><a href="index.html">by IIITRANCHI <span></span></a></div>
				<a href="#menu">MENU</a>
			</header>

		<!-- Nav -->
			<nav id="menu">
				<ul class="links">
				    <li><a href="index.php">Home</a></li>
					<li><a href="login.php">Sign In</a></li>
					<li><a href="register.php">Sign Up</a></li>
				
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
		
	

	<div class="header">
  	<h2>Register</h2>
  </div>
	
  <form method="post" action="register.php">
  	<?php include('errors.php'); ?>
  	    	<div class="input-group">
  	  <label for="type">SIGNUP TYPE</label>
  <select id="type" name="type" onchange="myFunction()">
    <option value="O">Organiser</option>
    <option value="U">User</option>
    
  </select>
  	</div>
  		<div class="input-group">
  	  <label>Full Name</label>
  	  <input type="text" name="fullname"  value="<?php echo $fullname; ?>">
  	</div>
  		<div class="input-group">
  	  <label>Institute Name</label>
  	  <input type="text" name="institute"  value="<?php echo $institute; ?>">
  	</div>
  
  		<div class="input-group" id='grad' style="display:none">
  	  <label>Graduation Year </label>
  	  <input type="text" name="grad_year"  value="<?php echo $grad_year; ?>">
  	</div>
  	<div class="input-group" >
  	  <label>Email ID</label>
  	  <input type="email" name="email" value="<?php echo $email; ?>">
  	</div>
  	<div class="input-group">
  	  <label>Contact Number</label>
  	  <input type="text" name="contact" value="<?php echo $contact; ?>">
  	</div>
  	<div class="input-group">
  	  <label>Choose a Unique Username</label>
  	  <input type="text" name="username" value="<?php echo $username; ?>">
  	</div>
  	
  	<div class="input-group">
  	  <label>Select a Password</label>
  	  <input type="password" name="password_1">
  	</div>
  	<div class="input-group">
  	  <label>Confirm password</label>
  	  <input type="password" name="password_2">
  	</div>
  	<div class="input-group">
  	  <button type="submit" class="btn" name="reg_user">Register</button>
  	</div>
  	<p>
  		Already a member? <a href="login.php">Sign in</a>
  	</p>
  </form>
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
			
	<script>
function myFunction() {
  var x = document.getElementById("type").value;
  if (x == 'U') {
        document.getElementById('grad').style.display = 'block';
      <?php echo "working"; ?>
    } else {
        document.getElementById('grad').style.display = 'none';
    }
}
</script>

	</body>
</html>
