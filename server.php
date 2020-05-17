<?php
session_start();

// initializing variables
$fullname="";
$institute="";
$contact="";
$grad_year="";
$username = "";
$email    = "";
$errors = array();
$type='';



// connect to the database
$db = mysqli_connect('localhost', 'id13666357_useriiitr', 'WebHosting@123', 'id13666357_hackovid');

// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $type = mysqli_real_escape_string($db, $_POST['type']);
  $fullname = mysqli_real_escape_string($db, $_POST['fullname']);
  $institute = mysqli_real_escape_string($db, $_POST['institute']);
  $grad_year = mysqli_real_escape_string($db, $_POST['grad_year']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $contact = mysqli_real_escape_string($db, $_POST['contact']);
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);
  

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($fullname)) { array_push($errors, "Full Name is required"); }
  if (empty($institute)) { array_push($errors, "Institute Name is required"); }
  if (empty($grad_year) && $type=='U') { array_push($errors, "Graduation year is required"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($contact)) { array_push($errors, "Contact is required"); }
  if (empty($username)) { array_push($errors, "Username is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if ($password_1 != $password_2) {
	array_push($errors, "The two passwords do not match");
  }

  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  if ($type=='O'){
       $user_check_query = "SELECT * FROM ORGANISER WHERE USERNAME='$username' OR EMAIL_ID='$email' LIMIT 1";
  }
  else{
  $user_check_query = "SELECT * FROM USERS WHERE USERNAME='$username' OR EMAIL_ID='$email' LIMIT 1";
  }
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['USERNAME'] === $username) {
      array_push($errors, "Username already exists");
    }

    if ($user['EMAIL_ID'] === $email) {
      array_push($errors, "email already exists");
    }
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
  	$password = md5($password_1);//encrypt the password before saving in the database
  	if ($type==='O'){ 
  	    	$query = "INSERT INTO ORGANISER (INSTITUTE, NAME, EMAIL_ID, MOBILE_NO, USERNAME, PASSWORD) 
  			  VALUES('$institute', '$fullname', '$email', '$contact', '$username', '$password')";
  	}
    elseif($type==='U'){
  	$query = "INSERT INTO USERS (NAME, INSTITUTE, GRADUATION_YEAR, EMAIL_ID, PHONE, USERNAME, PASSWORD) 
  			  VALUES( '$fullname', '$institute', '$grad_year', '$email', '$contact', '$username', '$password')";
    }
  	if(mysqli_query($db, $query))
  	{
  	$_SESSION['username'] = $username;
  	$_SESSION['success'] = "You are now logged in";
  	header('location: login.php');
  
  	}
  	else
  	   echo("Error description: " . mysqli_error($db));
  	    
  	
  }
}

// ... 
// LOGIN USER
if (isset($_POST['login_user'])) {
  $type = mysqli_real_escape_string($db, $_POST['type']);
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

  if (empty($username)) {
  	array_push($errors, "Username is required");
  }
  if (empty($password)) {
  	array_push($errors, "Password is required");
  }

  if (count($errors) == 0) {
  
  	if($type == 'O'){	$password = md5($password);
  	$query = "SELECT * FROM ORGANISER WHERE USERNAME='$username' AND PASSWORD='$password'";}
  	elseif($type == 'U'){	$password = md5($password);
  	$query = "SELECT * FROM USERS WHERE USERNAME='$username' AND PASSWORD='$password'";}
  	else{
  	$query = "SELECT * FROM ADMIN WHERE USERNAME='$username' AND PASSWORD='$password'";}
  	if(mysqli_query($db, $query)){
  	$results = mysqli_query($db, $query);
  	if (mysqli_num_rows($results) == 1) {
  	  $_SESSION['username'] = $username;
  	  $_SESSION['success'] = "You are now logged in";
  	  	if($type == 'O')
  	  header('location: organiser_dashboard.php');
  	  elseif($type == 'U')
  	   header('location:user_homepage.php');
  	   else
  	   header('location:admin_homepage.php');
  	}else{echo(mysqli_num_rows($results));
  		array_push($errors, "Wrong username/password combination ");}
  	}else
  	 echo("Error description: " . mysqli_error($db));
  	
  }
}

//COMMENT
if (isset($_POST['comment'])) {
  // receive all input values from the form
  $id = mysqli_real_escape_string($db, $_POST['event_id']);
  $name = mysqli_real_escape_string($db, $_POST['name']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $human = mysqli_real_escape_string($db, $_POST['human']);
  $message = mysqli_real_escape_string($db, $_POST['message']);
   if (empty($name)) {
  	array_push($errors, "Name is required.");
  }
  if (empty($email)) {
  	array_push($errors, "Email is required.");
  }
   if (empty($human)) {
  	array_push($errors, "Please Confirm you are human.");
  }
  if (empty($message)) {
  	array_push($errors, "please click on send after writing something in message box.");
  }
  if (count($errors) == 0) {
  $query = "INSERT INTO COMMENTS_QUERIES ( EVENT_ID, AUTHOR, QUERY) 
  			  VALUES('$id', '$name', '$message')";
  if(mysqli_query($db, $query))
  	{
  
  	header("location: user_event.php?EVENT_ID=$id ");
  
  	}
  	
 
}
else
  	  	header("location: user_event.php?ERRORS=1&EVENT_ID=$id ");
}
?>