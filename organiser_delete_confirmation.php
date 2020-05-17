<?php
session_start();

if(!isset($_GET['EVENT_ID']) && !isset($_GET['username']) )
{
    header('location:organiser_dashboard.php');

}
if(isset($_GET['EVENT_ID'])){
$_SESSION['temp1'] = $_GET['EVENT_ID'];
$eventid = $_GET['EVENT_ID'];}
require_once "pdo.php";
if(isset($_GET['DATA']))
{
    $sql = "DELETE FROM ORGANISER_DATA WHERE EVENT_ORGANISED_ID = :SEID";
    $stmt = $pdo -> prepare($sql);
    $stmt -> execute(array(':SEID' => $_SESSION['temp1']));
    $sql = "DELETE FROM EVENTS WHERE EVENT_ID = :SEID";
    $stmt = $pdo -> prepare($sql);
    $stmt -> execute(array(':SEID' => $_SESSION['temp1']));
    unset($_SESSION['temp1']);
    $_SESSION['message'] = "Event Successfully deleted.";
    echo("<script>window.location.replace('organiser_dashboard.php');</script>");
}
?>

<html>
<head>
<title>Organiser_delete_confirmation</title>
<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<br><br><br><br>
<div class="content">
<header class = "align-center">
<h2><br>
Hey ! Hold on there !
</h2>
<p>.</p>
<P>
<h2>Are you sure you want to delete this event???</h2>
<b>Event Name:</b><br> <h2>
<?php
$sql = "SELECT * FROM EVENTS WHERE EVENT_ID = :SEID";
$stmt = $pdo -> prepare($sql);
$stmt -> execute(array(':SEID' => $_SESSION['temp1']));
$R298 = $stmt->fetch();
echo($R298['EVENT_NAME']);?>
</h2>
<br>
<h1>This event cannot be undone</h1></P>

<button type = "submit" name = "YES" onclick = "location.href='organiser_delete_confirmation.php?DATA=1';">YES , Delete it</button>       
<button type = "submit" name = "NO" onclick = "location.href='organiser_dashboard.php';">NO , Get me back.</button>
</div>
</body>
</html>