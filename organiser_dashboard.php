<?php
/*
    This file contains the page for organiser dashboard.
    This page shows details of various events(past, present and future) organised by the particular organisation.
    It also shows delails of any particular event.
    Also provides the organiser an option to add a new event , or update an existing one.
*/  

session_start();
if(!isset($_SESSION['username']))		//Verification of authentic access
{
	header("location:login.php");
}
$Data = NULL;
if(isset($_GET['ACTION']))				//Handle formfeed for action button click
{
	if($_GET['ACTION'] == 'DETAILS')
	{
		$Data = $_GET['EVENT_ID'];
		
	}
	else if($_GET['ACTION'] == "DELETE" )
	{
		header("location:organiser_delete_confirmation.php?EVENT_ID=".$_GET['EVENT_ID']."");
		return;
	}
	else if($_GET['ACTION'] == "EDIT" )
	{
		header("location:organiser_edit.php?EVENT_ID=".$_GET['EVENT_ID']."");
		return;
	}
}
require_once "pdo.php";
if(!isset($_SESSION['Organiser_Institute']))		//Obtains data about organising institute
{
    $sql = "SELECT * FROM ORGANISER WHERE USERNAME = :OID";
    $stmt = $pdo -> prepare($sql);
    $stmt -> execute(array(':OID' => $_SESSION['username']));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $_SESSION['Organiser_Institute'] = $row['INSTITUTE'];
    $_SESSION['Organiser_Name'] = $row['NAME'];
    $_SESSION['Organiser_id'] = $row['ORGANISER_ID'];
}

$ORGANISER_ID = $_SESSION['Organiser_id'] ;

		//Handles data sent through POST parameters using form feed
if(isset($_POST['ENAME']) && isset($_POST['SDATE']) && isset($_POST['STIME']) && isset($_POST['EDATE']) && isset($_POST['ETIME']) && isset($_POST['PRIZES']) && isset($_POST['DESCRIPTION']) && isset($_POST['REGISTRATION_FORM']))
{	$begin=htmlentities($_POST['SDATE'])." ".htmlentities($_POST['STIME']).":00";
	$end=htmlentities($_POST['EDATE'])." ".htmlentities($_POST['ETIME']).":00";
	$sql = "INSERT INTO EVENTS(EVENT_NAME , ORGANISER_ID , BEGIN_DATE_TIME , END_DATE_TIME , REGISTRATIONS , PRIZES , DESCRIPTION , REGISTRATION_FORM) VALUES(:V1,:V2,:V3,:V4,:V5,:V6,:V7,:V8)";
    $stmt = $pdo -> prepare($sql);
	$stmt -> execute(array( ':V1' => htmlentities($_POST['ENAME']),
							':V2' => $_SESSION['Organiser_id'],
							':V3' => $begin,
							':V4' => $end,
							':V5' => 0,	 
							':V6' => htmlentities($_POST['PRIZES']),
							':V7' => htmlentities($_POST['DESCRIPTION']),
							':V8' => htmlentities($_POST['REGISTRATION_FORM']),));
			$LAST_EVID = $pdo -> lastInsertId();
	$sql = "INSERT INTO ORGANISER_DATA(ORGANISER_ID ,EVENT_ORGANISED_ID) VALUES(:V1,:V2)";
	$stmt = $pdo -> prepare($sql);
	$stmt -> execute(array( ':V1' => $_SESSION['Organiser_id'] , ':V2' => $LAST_EVID));	
	$_SESSION['message'] = "Record successfully added.";
}

			//For past events
	$sql1 = "SELECT * FROM EVENTS WHERE END_DATE_TIME <= cast((NOW()) AS date);";
    $stmt = $pdo -> prepare($sql1);
    $stmt -> execute();
    $row1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($row1 as $rows)
    {	$sql11 = 'UPDATE EVENTS SET STATUS = "PAST" WHERE EVENT_ID = :evid1;';
        $stmt11 = $pdo -> prepare($sql11);
		$stmt11 -> execute(array(":evid1" => $rows['EVENT_ID'],));
	}
			//For present events
	$sql1 = "SELECT * FROM EVENTS WHERE BEGIN_DATE_TIME >= cast((NOW()) AS date);";
    $stmt = $pdo -> prepare($sql1);
    $stmt -> execute();
    $row1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($row1 as $rows)
    {	$sql11 = 'UPDATE EVENTS SET STATUS = "UPCOMING" WHERE EVENT_ID = :evid1;';
        $stmt11 = $pdo -> prepare($sql11);
		$stmt11 -> execute(array(":evid1" => $rows['EVENT_ID'],));
	}
			//for future events
	$sql1 = "SELECT * FROM EVENTS WHERE BEGIN_DATE_TIME < cast((NOW()) AS date) AND END_DATE_TIME > cast((NOW()) AS date);";
    $stmt = $pdo -> prepare($sql1);
    $stmt -> execute();
    $row1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($row1 as $rows)
    {	$sql11 = 'UPDATE EVENTS SET STATUS = "PRESENT" WHERE EVENT_ID = :evid1;';
        $stmt11 = $pdo -> prepare($sql11);
		$stmt11 -> execute(array(":evid1" => $rows['EVENT_ID'],));
	}
?>

<html>
	<head>
		<title>Organiser Dashboard</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body class = "subpage">
		<header id="header" class="reveal" >
			<div class="logo">
			<a href="#">Organiser Dashboard</a>
			</div>
				<a href = "organiser_homepage.php"> Home</a>
		</header>
		<section id="One" class="wrapper style3">			
			<div class="inner">
				<header class="align-center">
					<p><?php echo($_SESSION['Organiser_Institute'])?></p>
					<h2><?php echo($_SESSION['Organiser_Name']);?></h2>
				</header>
			</div>
		</section>
						<div id="main" class="container">
		<br><a id="top"></a>
		</div>
		
		<?php
		if(isset($_SESSION['message']))
		{
		    echo("<div class = 'error success'>".$_SESSION['message']."</div>");
		    unset($_SESSION['message']);
		}
		?>
		<br>
		<div style = "margin-left:50px; margin-right:50px;">
		<div class = "table wrapper">
		<table>
			<caption>
				Past Events
			</caption>
			<thead>
				<tr>
					<td>Events</td>
					<td>Start Date & Time</td>
					<td>End Date & Time </td>
					<td>Registrations</td>
					<td>Visible</td>
					<td>Action</td>
				</tr>
            </thead>
            <?php
                
                $sql = "SELECT * FROM EVENTS  WHERE ORGANISER_ID = :OID AND STATUS = 'PAST';";
                $stmt = $pdo -> prepare($sql);
                $stmt -> execute(array(':OID' => $_SESSION['Organiser_id']));
                $row1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($row1 as $rows)
                {   if($rows['REVIEW']==0)
                    {
                       $astatus = "YES" ;
                    }
                    else
                    {
                        $astatus = "NO";
                    }
                    echo("<tr>");
                    echo("<td>".$rows['EVENT_NAME']."</td>");
                    echo("<td>".$rows['BEGIN_DATE_TIME'] ."</td>");
					echo("<td>".$rows['END_DATE_TIME'] ."</td>");
					echo("<td>".$rows['REGISTRATIONS'] ."</td>");
					echo("<td>".$astatus ."</td>");
                    echo('<td><a href = "organiser_dashboard.php?ACTION=DETAILS&EVENT_ID='.$rows['EVENT_ID'].'" class = "button special">Details</a>		<a href = "organiser_dashboard.php?ACTION=EDIT&EVENT_ID='.$rows['EVENT_ID'].'" class = "button special">Edit</a>		<a href = "organiser_dashboard.php?ACTION=DELETE&EVENT_ID='.$rows['EVENT_ID'].'" class = "button special" >Delete</a></td>');
                    echo("</tr>");
                }
                ?>
			</table>
		</div>
		<div class = "table wrapper">
			<table>
				<caption>
					Present Events
			</caption>
			<thead>
				<tr>
					<td>Events</td>
					<td>Start Date & Time</td>
					<td>End Date & Time </td>
					<td>Registrations</td>
					<td>Visible</td>
					<td>Action</td>
				</tr>
            </thead>
            <?php
                $sql = "SELECT * FROM EVENTS  WHERE ORGANISER_ID = :OID AND STATUS = 'PRESENT';";
                $stmt = $pdo -> prepare($sql);
                $stmt -> execute(array(':OID' => $_SESSION['Organiser_id']));
                $row1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($row1 as $rows)
                {
                    if($rows['REVIEW']==0)
                    {
                       $astatus = "YES" ;
                    }
                    else
                    {
                        $astatus = "NO";
                    }
                    echo("<tr>");
                    echo("<td>".$rows['EVENT_NAME']."</td>");
                    echo("<td>".$rows['BEGIN_DATE_TIME'] ."</td>");
					echo("<td>".$rows['END_DATE_TIME'] ."</td>");
					
					echo("<td>".$rows['REGISTRATIONS'] ."</td>");
					echo("<td>".$astatus ."</td>");
                    echo('<td><a href = "organiser_dashboard.php?ACTION=DETAILS&EVENT_ID='.$rows['EVENT_ID'].'" class = "button special">Details</a>		<a href = "organiser_dashboard.php?ACTION=EDIT&EVENT_ID='.$rows['EVENT_ID'].'" class = "button special">Edit</a>		<a href = "organiser_dashboard.php?ACTION=DELETE&EVENT_ID='.$rows['EVENT_ID'].'" class = "button special" >Delete</a></td>');
                    echo("</tr>");
                }
                ?>
			</table>
		</div>
		<div class = "table wrapper">
			<table>
				<caption>
					Upcoming Events
			</caption>
				<thead>
					<tr>
					<td>Events</td>
					<td>Start Date & Time</td>
					<td>End Date & Time </td>
					<td>Registrations</td>
					<td>Visible</td>
					<td>Action</td>
				</tr>
            </thead>
            <?php
                $sql = "SELECT * FROM EVENTS  WHERE ORGANISER_ID = :OID AND STATUS = 'UPCOMING';";
                $stmt = $pdo -> prepare($sql);
                $stmt -> execute(array(':OID' => $_SESSION['Organiser_id']));
                $row1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($row1 as $rows)
                {
                   if($rows['REVIEW']==0)
                    {
                       $astatus = "YES" ;
                    }
                    else
                    {
                        $astatus = "NO";
                    }
                    echo("<tr>");
                    echo("<td>".$rows['EVENT_NAME']."</td>");
                    echo("<td>".$rows['BEGIN_DATE_TIME'] ."</td>");
					echo("<td>".$rows['END_DATE_TIME'] ."</td>");	
					echo("<td>".$rows['REGISTRATIONS'] ."</td>");
					echo("<td>".$astatus ."</td>");
                    echo('<td><a href = "organiser_dashboard.php?ACTION=DETAILS&EVENT_ID='.$rows['EVENT_ID'].'" class = "button special">Details</a>		<a href = "organiser_dashboard.php?ACTION=EDIT&EVENT_ID='.$rows['EVENT_ID'].'" class = "button special">Edit</a>		<a href = "organiser_dashboard.php?ACTION=DELETE&EVENT_ID='.$rows['EVENT_ID'].'" class = "button special" >Delete</a></td>');
                    echo("</tr>");
                }
                ?>
			</table>
			</div>
			</div>
			<div id="main" class="container">
				<div class="content">
				<header class = "align-center">					
					<p>
						Please click on details button of any event from above to view its details
					</p>
					<h2>		<br>
						Details
					</h2>
					<p>		</p>
					<div style="word-wrap:break-word;">
					<?php
					$loc = 'images/def.jpg';
					$sql123 = "SELECT * FROM IMAGES  WHERE EVENT_ID = :Data123";
					$stmt123 = $pdo -> prepare($sql123);
					$stmt123 -> execute(array(':Data123' => $Data));
					$row123 = $stmt123->fetchAll(PDO::FETCH_ASSOC);
					foreach($row123 as $re)
					{
						$loc = $re['IMAGES'];
						break;
					}					
					$sql = "SELECT * FROM EVENTS  WHERE EVENT_ID = :Data";
					$stmt = $pdo -> prepare($sql);
					$stmt -> execute(array(':Data' => $Data,));
					$row1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
					foreach ($row1 as $rows)
					{	
					    if(($rows['REVIEW']) == 0)
					    {
					        $astatus = "RUNNING FINE";
					    }
					    else if(($rows['REVIEW']) == 1)
					    {
					        $astatus = "Marked for Review";
					    }
					    else 
					    {
					        $astatus = "Deleted";
						}
								//Shows details about selected event
					    echo("<img src='".$loc."' width = 600em height = auto style='max-width:100%;' alt ='Image Unavailable'/>");
						echo("<h1><br><br>");
						echo("<b>Event Name</b>			:	<br>".$rows['EVENT_NAME']."<br><br>");
						echo("<b>Start Date and Time</b>	:	<br>".$rows['BEGIN_DATE_TIME']."<br><br>" );
						echo("<b>End Date and Time</b> 	:	<br>".$rows['END_DATE_TIME']."<br><br>" );
						echo("<b>Students Registered</b> 	:	<br>".$rows['REGISTRATIONS']."<br><br>" );
						echo("<b>Admin Status</b> 	:	<br>".$astatus."<br><br>" );
						echo("<b>Registration Form Link</b> 	:	<br><a href ='".$rows['REGISTRATION_FORM']."'>".$rows['REGISTRATION_FORM']."</a><br><br>" );
						echo("<b>Status</b>				:	<br>".$rows['STATUS']."<br><br>" );
						echo("<b>Prizes</b>			 	:	<br>".$rows['PRIZES']."<br><br>" );
						echo("<b>Description</b>			:	<br>".$rows['DESCRIPTION']."<br><br>" );
						echo("</h1>");
						}
						?>
						</div>
					<?php
					if(isset($_GET['EVENT_ID'])){ echo('<a href = "comment_QA.php?EVENT_ID='. $_GET['EVENT_ID'].' " class = "button">Queries and comments</a>');}?>
				</header><br>
				</div>
			</div>
			<div class="content">
					<br>Add an event:
					<br><br>
				<form method = "post">
					<div class = "6u 12u$(small)">
						<label for="Ename">Event Name</label><input type="text" name="ENAME" id="Ename" value placeholder="Competion Event name" required>
					</div><br>
					<div class = "6u 12u$(small)">
						<label for="start_date">Start  Date  &  Time</label><input type="date" name="SDATE" id="date"  required>    <input type="time" name="STIME" id="time" REQUIRED>
					</div><br>
					<div class = "6u 12u$(small)">  
						<label for="end_date">End  Date  &  Time</label><input type="date" name="EDATE" id="date" required>    <input type="time" name="ETIME" id="time" REQUIRED>
					</div><br>
					<div class = "6u 12u$(small)">
						<label for="Rform">Registration form link</label><input type="text" name="REGISTRATION_FORM" id="Rform" value placeholder="Google forms(sort of)" required>
					</div><br>
					<div class="12u$">
						<label for="Prizes">Prizes</label>
						<textarea name="PRIZES" id="message" placeholder="Enter delails about prizes(if applicable)." rows="6" cols="20"></textarea>
					</div><br>
					<div class="12u$">
						<label for="description">Description</label>
						<textarea name="DESCRIPTION" id="message" placeholder="Enter a breif description of your competition." rows="6" cols="20"></textarea>
					</div><br>										
                        <p>Note- upload poster for your event in edit section after submitting this form.</p>
					<br>
					<input type = "submit" value="add" name="Add" class = "button special ">              
					<button type = "button" value="Clear" name="Clear" class = "button special " onclick="location.href='organiser_dashboard.php';">Clear</button>
				</form>
		</div>
	<br><br>
	<!-- Footer -->
	<footer id="footer">
				<div class="container">
					<ul class="icons">
						<li><a href="https://twitter.com/IIITRanchi" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
						<li><a href="https://www.facebook.com/IIITRanchiOfficial/" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
						<li><a href="https://www.instagram.com/its_iiit_ranchi/" class="icon fa-instagram"><span class="label">Instagram</span></a></li>
						<li><a href="#" class="icon fa-envelope-o"><span class="label">Email</span></a></li>
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

<style>
	caption
	{
		font-size : 1.8em;
		font-weight:bold;
	}
	
</style>

<!-- 
                                               Authors:
         Rishav Mazumdar ( 2019UGEC013R )           Tushar Jain ( 2019UGCS001R )
-->                
