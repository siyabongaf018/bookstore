<?php
session_start();
include('dbconn.php');
if(!isset($_SESSION['email'])){
    header("location:index.php");
}

if(isset($_POST['submit']))
{
    header("location:login.php");
    unset($_SESSION['email']);  
    session_destroy(); 
}

?>
<!DOCTYPE html>
<html>

<head>
    <title></title>  
	<link rel="stylesheet" href="css/style.css">
	<style>
	
	body{
		background: rgba(253, 253, 253, 0.86);
	}
	
	</style>
</head>

<body>
<center> <div class="headerBIO">Books.io</div></center>
<div class="topnav">
  <a class="active" href="verifystudent.php">Home</a>
  <a href="adminViewBooks.php">View books</a>
  <a href="test.php">View test</a>
  <a href="#contact">Contact</a>
  <a href="aboutUs.php">About</a>
</div>


</body>
</html>