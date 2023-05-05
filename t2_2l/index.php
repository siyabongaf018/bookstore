
<?php

session_start();

If(!isset($_SESSION['email']))
{
	header('location:login.php');
}
?>

<!DOCTYPE>
<html>
<head>
<title>Indexpage</title>
<link rel="stylesheet" href="css/style.css">
<style>

.footer{
position:fixed;
left:0;
bottom:0;
width:100%;
height:120px;
color:white;
background-color:red;
}

.footer td {
	color:white;
}
</style>
</head>
<body>

<center> <div class="headerBIO">Books.io</div></center>
<HR>
<div class="topnav">
  <a class="active" href="index.php">Home</a>
  <a href="viewbooks.php">View books</a>
  <a href="aboutUs.php">About Us</a>
</div>
<br>
<h3>Home page</h3>
<p>Enjoy your shopping  <b><?php echo $_SESSION['email']; ?></b> </p>
	



 
 <div class="footer">
<table>
  <tr>
    <th>Contact Us</th>
    <th>Menu</th>
    <th>Follow Us</th>
  </tr>
  <tr>
    <td>Email:<a href="">BooksIO@gmail.com</a></td>
    <td><a href="index.php">Home</a></td>
    <td>Twitter: BooksIO</td>
  </tr>
  <tr>
    <td>Address:310 Schoeman Street</td>
    <td><a href="viewbooks.php">View books</a></td>
    <td>Instagram: booksio</td>
  </tr>
</table>
</div> 
</body>

</html>
