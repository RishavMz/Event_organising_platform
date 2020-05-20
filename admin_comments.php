<?php
session_start();

if(isset($_GET['EVENT_ID']))
{
	$_SESSION['TEMP'] = $_GET['EVENT_ID'];
}
require_once "pdo.php";
if(isset($_POST['comment']) && isset($_POST['reply'])  && isset($_POST['query_id']))
{
	$sql = "INSERT INTO COMMENTS_ANSWERS(EVENT_ID , QUERY_ID , AUTHOR , ANSWER) VALUES(:V1 , :V2 , 'ADMIN', :V4)";
    $stmt = $pdo -> prepare($sql);
	$stmt -> execute(array('V1'=>$_SESSION['TEMP'],
								'V2' =>$_POST['query_id'],
						'V4' => htmlentities($_POST['comment']),));
						$_SESSION['message'] = "Reply added successfully.";

}
if(isset($_POST['query']) && isset($_POST['POST']) )
{
	$sql = "INSERT INTO COMMENTS_QUERIES(EVENT_ID , QUERY, AUTHOR) VALUES(:V1 , :V2 , 'ADMIN')";
    $stmt = $pdo -> prepare($sql);
	$stmt -> execute(array('V1'=>$_SESSION['TEMP'],
								'V2' => htmlentities($_POST['query']),
						));
						$_SESSION['message'] = "Query added successfully.";

}
else if( isset($_POST['delete']) && isset($_POST['query_id']))
{
	$sql = "DELETE FROM COMMENTS_ANSWERS WHERE QUERY_ID = :qid";
	$stmt = $pdo -> prepare($sql);
	$stmt -> execute(array(':qid' => $_POST['query_id']));
	$sql = "DELETE FROM COMMENTS_QUERIES WHERE QUERY_ID = :qid";
	$stmt = $pdo -> prepare($sql);
	$stmt -> execute(array(':qid' => $_POST['query_id']));
	$_SESSION['message'] = "Query and its comments deleted.";
}
if(isset($_GET['ORGANISER_ID']))
{
    $sql = "SELECT NAME,INSTITUTE FROM ORGANISER WHERE ORGANISER_ID = :OID";
    $stmt = $pdo -> prepare($sql);
    $stmt -> execute(array(':OID' => $_GET['ORGANISER_ID']));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $_SESSION['Organiser_Institute'] = $row['INSTITUTE'];
    $_SESSION['Organiser_Name'] = $row['NAME'];
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
				<a href = admin_event.php?EVENT_ID=<?php echo($_SESSION['TEMP']); ?>>Back</a>
			</div>
			<a href = "admin_homepage.php" >Home</a>
		</header>
		<section id="One" class="wrapper style3">			
			<div class="inner">
				<header class="align-center">
				<p><?php echo($_SESSION['Organiser_Institute'])?></p>
					<h2><?php echo($_SESSION['Organiser_Name'])?></h2>
				</header>
			</div>
		</section>
		

		<div id="main" class="container">
            <br>
            <?php
		if(isset($_SESSION['message']))
		{
		    echo("<div class = 'error success'>".$_SESSION['message']."</div>");
		    unset($_SESSION['message']);
		}?><br>
			
			<header>
            <form method = "post" name = "query">
                Add a query<br>
					<textarea name = "query" value placeholder="Add a query"></textarea>
				<br>
				<div class="6u$ 12u$(small)">
			</div>
				<button class = "button special" id="POST" value = "POST" name = "POST" onclick = post>POST</button>
				<button class="button special" id="clear" value = "clear" name="clear" onclick = location.href="#">CLEAR</button>
				<br>
				</form>
				<br><br><br>
				<?php
				$sql = "SELECT * FROM COMMENTS_QUERIES WHERE EVENT_ID = :snid";
				$stmt = $pdo -> prepare($sql);
				$stmt -> execute(array('snid' => $_SESSION['TEMP'],));
				$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
				foreach($row as $rows)
				{   if(count($row) == 0){
				    echo("<h2>No queries have been posted for this event yet.</h2>");
				}
					echo('<div class="content">');
					 echo("<ul><li>");
					$QID = $rows['QUERY_ID'];
					echo("<h2>".$rows['QUERY']."</h2>");
				echo("<p>	<t>".$rows['AUTHOR']."</t></p>");
					$sql1 = "SELECT * FROM COMMENTS_ANSWERS WHERE QUERY_ID = :sn";
					$stmt1 = $pdo -> prepare($sql1);
					$stmt1 -> execute(array('sn' => $QID,));
					$row1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
					foreach($row1 as $rows1)
					{
				echo('<ul style="list-style: none;">
					<li>
						<blockquote>');
				echo($rows1['ANSWER']);
				echo("<p> <t>".$rows1['AUTHOR']."</t></p>");
				echo("		</blockquote>
					</li>
			</ul>
				<br>");}?>
				<form method = "post" name = "<?php $QID?>">
					<textarea name = "comment" value placeholder="Add a reply"></textarea>
				<br>
				<div class="6u$ 12u$(small)">
			</div>
						<input type="hidden" name="query_id" value= "<?php echo($QID);?>" >
				<button class = "button special" id="reply" value = "reply" name = "reply" onclick = post>Reply</button>
				<button class="button special" id="delete" value = "delete" name="delete" onclick = post>This Query seems offensive??? Delete it</button>
				<br>
				</form>
			</li>
				<?php 
			echo("</div><br><br>");} ?>
		</div>

		<!-- Footer -->
<footer id="footer">
				<div class="container">
					<ul class="icons">
						<li><a href="#" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
						<li><a href="#" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
						<li><a href="#" class="icon fa-instagram"><span class="label">Instagram</span></a></li>
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
