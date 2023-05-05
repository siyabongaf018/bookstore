<?php
session_start();
$sqlerror = null;
include('dbconn.php');
if(!isset($_SESSION['email'])){
    header("location:index.php");
}
$BookTitle = $BookId = $Category = $imageURL = $BookPrice= $Quantity =  null;
$output ="ccya";
$BookId = $_SESSION['bookid'];
$error = 0 ;

if(isset($_POST['Back'])){
	echo "back";
	header("location:adminViewBooks.php");
}


if(isset($_POST['Update'])){

$BookTitle = $_POST['bookTitle'];
$Category = $_POST['Category'];
$BookPrice = $_POST['BookPrice'];
$Quantity = $_POST['Quantity'];

if(empty($BookTitle)){
	$output = "Book Title is empty";
	$error =1;
}elseif(empty($Category)){
	$output = "Category is empty";
	$error =1;
}elseif(empty($BookPrice)){
	$output = "Book Price is empty";
	$error =1;
}elseif($error == 0){
	echo "<br> BookId : ". $BookId;
	$sql = "UPDATE tblbooks SET bookTitle = '$BookTitle', category = '$Category', price = '$BookPrice',qnty = '$Quantity' where bookid ='$BookId'";
	$updateBook = mysqli_query($conn, $sql);
	
	echo "<br> query".$sql;
	
	
	echo "<br>dd". $updateBook;
	if($updateBook){
		$output = "Book ". $BookTitle . " updated";
		header("location:adminViewBooks.php");
	}
	else{
		$output = "Book ". $BookTitle . " not updated";
	}
	
}
$output = "Book ". $BookTitle . " updated";
$_SESSION['email']= "";
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
<div class="topnav">
  <a  href="verifystudent.php">Verify user</a>
  <a  href="verifiedUser.php">Verified user</a>
  <a class="active" href="adminViewBooks.php">View books</a>
  <a  href="adminAddBook.php">Add book</a>
  <a href="logout.php">logout</a>
</div>
<br><hr>
<br>
<h4><?php $output; ?></h4>
<center>
<?php   
$sql = "SELECT * FROM tblbooks where bookid ='$BookId'";
$query = mysqli_query($conn,$sql);

//retriving books details from the database
if(mysqli_num_rows($query) > 0){
    while($result = mysqli_fetch_assoc($query)){
        $imageURL = $result["image"];
        $textBookTitle = $result["bookTitle"];
		$category = $result["category"];
        $textBookSellPrice = $result["price"];
		$textBookQuantity = $result["qnty"];
		
?>
<form method= "post" action="">
<?php $output; ?>
<img src="<?php echo $imageURL; ?>" alt="" />
<div class= "input-group"> 
  <label for="bookTitle">Book Title:</label><br>
  <input type="text" id="lname" name="bookTitle" value = "<?php echo $textBookTitle ;  ?>"><br>
  </div> 
  
  <div class= "input-group"> 
  <label for="Category">Category:</label><br>
  <input type="text" id="Category" name="Category" value = "<?php echo $category;  ?>"  ><br>
  </div> 
  
  <div class= "input-group"> 
  <label for="BookPrice">Book Price:</label><br>
  <input type="number" min="0.00" max="10000000.00" step="0.01" id="BookPrice" name="BookPrice" value = "<?php echo $textBookSellPrice;  ?>"><br><br>
  </div> 
  
  <div class= "input-group"> 
  <label for="Quantity">Quantity: <h4><?php $output; ?></h4></label><br>
  <input type="number" id="Quantity" name="Quantity" value = "<?php echo $textBookQuantity;  ?>"><br><br>
  </div> 
  
   <button type = "submit" class="btn" name="Update">Update</button><br>
   <br>
    <button type = "submit" class="btn" name="Back">Back</button><br>



</form>
<?php }
}

else{ ?>
    <p>No book found</p>
<?php  echo $BookId;} ?>
</center>



</body>
</html>