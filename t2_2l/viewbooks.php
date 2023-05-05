<?php
session_start();
include('dbconn.php');
if(!isset($_SESSION['email'])){
    header("location:index.php");
}

if(isset($_POST['logout']))
{
    header("location:login.php");
    unset($_SESSION['email']);  
    session_destroy(); 
}

if(isset($_POST['AddToCart']))
{
	$_SESSION['bookid'] = $_POST['Bookid'];
    header("location:cart.php");
}

?>
<!DOCTYPE html>
<html>

<head>
    <title></title>  
	<link rel="stylesheet" href="css/style.css">

</head>

<body>
<center> <div class="headerBIO">Books.io</div></center>
<center>
    

        
    <br>
	<div class="topnav">
  <a href="index.php">Home</a>
  <a class="active"href="viewbooks.php">View books</a>
  <a href="aboutUs.php">About Us</a>
  <a href="cart.php">My cart</a>
  <a href="logout.php">Logout</a>
  
</div>

    <hr>
    <br><p>Enjoy your shopping  <b><?php echo $_SESSION['email']; ?></b> </p><br><hr>


<?php   
$sql = "SELECT * FROM tblbooks";
$query = mysqli_query($conn,$sql);

//retriving books details from the database
if(mysqli_num_rows($query) > 0){
    while($result = mysqli_fetch_assoc($query)){
        $imageURL = $result["image"];
        $textBookTitle = $result["bookTitle"];
		$category = $result["category"];
        $textBookSellPrice = $result["price"];
		$textBookQuantity = $result["qnty"];
		$Bookid = $result["bookid"];
?>
<div class="grid">
<table border="0" cellspacing="1" cellpadding="2" style="width:100%">
	<tr>
		<td><b>Cover Page:</b></td>
		<td><b>Book Details:</b></td> 
	</tr>
	<tr>
		<td>
			<img src="<?php echo $imageURL; ?>" alt="" />
		</td>
		<td>
			<p>Book Title: <?php echo $textBookTitle; ?></p>
			<p>Category: <?php echo $category; ?></p>
			<p >Book Price: <span style="color:rgb(70, 218, 25);" > <?php echo "<b>R </b>".$textBookSellPrice; ?></span> </p>
			<p>Available: <?php echo $textBookQuantity; ?></p>
			 
			<center>
			Quantity: <input type="number" value="1" style="width:30px"><br><br>
			
			<form method = "post" action="" style="width:70%;">
			<input type="hidden" name ="Bookid" value="<?php echo $Bookid; ?>">
			<input type="hidden" name ="BookPrice" value="<?php echo $textBookSellPrice; ?>">
			<button type="submit" name ="AddToCart" class="addtocart" onclick='alert("<?php echo "R ".$textBookSellPrice; ?>")' >Add to Cart</button>
			</form>
			 
			</center>
		</td>
    </tr>
	
	

</table>

</div>
<!-- closing caly brace for the if statment and while loop -->
<?php }
}

else{ ?>
    <p>No books found</p>
<?php } ?>


</body>
</html>