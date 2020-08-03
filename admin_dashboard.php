<?php
/*This file contains the admin dashboard page, which allows the admin to have an overview of the various events
    organised by various organisations.
  The various events(grouped by organisers) are shown with an option to perform certain actions on these events.
  This page also shows the student details who have signed up.
*/

session_start();
        //Handling the action command by button click
require_once "pdo.php";
if(isset($_GET['EVENT_ID']) && isset($_GET['ACTION']))
{
    if(($_GET['ACTION']) == "DELETE")
    {
        $sql = 'UPDATE EVENTS SET REVIEW = 2 WHERE EVENT_ID = :V1';
        $stmt1 = $pdo -> prepare($sql);
        $stmt1 -> execute(array(':V1' => $_GET['EVENT_ID'],));
    }
    else if(($_GET['ACTION']) == "ENABLE")
    {
        $sql = 'UPDATE EVENTS SET REVIEW = 0 WHERE EVENT_ID = :V1';
        $stmt1 = $pdo -> prepare($sql);
        $stmt1 -> execute(array(':V1' => $_GET['EVENT_ID'],));
    }
    else if(($_GET['ACTION']) == "MARK")
    {
        $sql = 'UPDATE EVENTS SET REVIEW = 1 WHERE EVENT_ID = :V1';
        $stmt1 = $pdo -> prepare($sql);
        $stmt1 -> execute(array(':V1' => $_GET['EVENT_ID'],));
    }
        
}
?>
<html>
	<head>
		<title>Admin Dashboard</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<link rel="stylesheet" type="text/css" href="style.css">
	<style>
	    table{font-size:1.8vw;}
	    @media screen and (max-width: 600px) {
  table {
    font-size: 1.8vh;
  }
}
	</style>
	</head>
	<body class = "subpage" >
		<!-- Header -->
			<header id="header">
				<div class="logo"><a href="http://iiitranchi.ac.in/">by IIITR</a></div>
				<a href="#menu">Menu</a>
			</header>

		<!-- Nav -->
			<nav id="menu">
				<ul class="links">
					<li><a href="admin_homepage.php">Home Page</a></li>
					<li><a href="admin_dashboard.php">Dashboard</a></li>
					<li><a href="delete.php">Deleted/Marked</a></li>
					<li><a href="admin_dashboard.php#user">User Details</a></li>
					<li><a href="logout.php">Logout</a></li>
					
				</ul>
			</nav>
		
		
         	<header class="align-center">
						<p class="special"><br><br><br>Click on More or the name of the event for delete/mark/comment_section option.</p>
						<h2>ORGANISERS</h2>
					</header>
        <?php 
        if(isset($_SESSION['message']))
		{
		    echo("<div class = 'error success'>".$_SESSION['message']."</div>");
		    unset($_SESSION['message']);
		}
                //Shows the various organisers 
        $sql = "select * from ORGANISER";
        $stmt = $pdo -> prepare($sql);
        $stmt -> execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach( $row as $rows)
        {
                $in = $rows['INSTITUTE'];
		?>
			
				
					<div class = "table wrapper">

				<table>
				    
				    <center><section class="wrapper style3">
				        	<div class="inner">
				<header class="align-center">
						<?php	
						echo('<p style="color:white;">'.$rows['INSTITUTE'].'</p>');
						echo('<h2><b>'.$rows['NAME'].'</span></b></h2>');?>
						</header>
						</div>
				</section></center><caption>
				    
				</caption>
				<div style="margin-left:15px; margin-feft:15px;">
				<table width=90%>
				<thead>
					<tr>
					<td>Event</td>
					<td>Status</td>
					<td>Review</td>
					<td>Registrations</td>
					<td>Action</td>
				</tr>
                </thead>
                <?php
                        //Groups the various events as per the organisers
                $sql1 = "SELECT * FROM EVENTS WHERE ORGANISER_ID = :V1";
                $stmt1 = $pdo -> prepare($sql1);
                $stmt1 -> execute(array(':V1' => $rows['ORGANISER_ID'],));
                $row1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
                foreach( $row1 as $rows1)
                {           //Checking the review by admin(numeric data) and converting it into a corredponding string
                    if($rows1['REVIEW'] == 0)
                    {
                        $astatus = "Working";
                    }
                    else if($rows1['REVIEW'] == 1)
                    {
                        $astatus = "Marked For Review";
                    }
                    else
                    {
                        $astatus = "Removed(by Admin)";
                    }
                   
                echo('    
                <tr>
                    <td >'.$rows1['EVENT_NAME'].'</td>
                    <td>'.$rows1["STATUS"].'</td>
                    <td>'.$astatus.'</td>
                    <td>'.$rows1["REGISTRATIONS"].'</td>
                    <td><a href = "admin_ess.php?EVENT_ID='.$rows1['EVENT_ID'].'" class = "button special">More</a></td></td>
                    </tr>');
                    }
			    echo('<br><table></div></div>
                    </div>');
                }
                ?>
	</div>
<br><br>
       	
        <div class = 'table wrapper'>
            <header class="align-center">
						<p class="special"><br><br><br>click on the user name to get more details</p>
						<h2 id="user">USERS LIST</h2>
					</header>
            <table width=100%>
            <thead>
                <tr>

                <td><b>Name</b></td>
                <td><b>Institute</b></td>
                <td><b>Graduation Year</b></td>
                
            </tr>
            </thead>
        <?php   
                    //Showing a list of all the users signed up under this platform
        $sql = 'SELECT * FROM USERS;';
        $stmt1 = $pdo -> prepare($sql);
        $stmt1 -> execute(array());
        $row1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
        foreach( $row1 as $rows1)
        {   
            echo('<tr>

                <td><a  href = admin_user_detail.php?USER_ID='.$rows1['USER_ID'].'>'.$rows1["NAME"].'</a></td>
                <td>'.$rows1["INSTITUTE"].'</td>
                <td>'.$rows1["GRADUATION_YEAR"].'</td>
              
            </td></tr>');
        }
        ?></table>
        
	<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>
</body></html>


<!-- 
                                               Authors:
         Rishav Mazumdar ( 2019UGEC013R )                Tushar Jain ( 2019UGCS001R )
-->              
