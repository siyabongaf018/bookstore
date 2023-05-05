<?php
session_start();
include('dbconn.php');
$Output = $BookId = "";

if(!isset($_SESSION['email'])){
    header("location:index.php");
}


if(isset($_POST['Update']))
{
	$_SESSION['bookid'] = $_POST['Bookid'];
    header("location:UpdateBooks.php");
}

if(isset($_POST['removebook']))
{
	
	$Output = $BookId. " deleted";
	$BookId = $_POST['Bookid'];
    $sql = "Delete from tblbooks where bookid ='$BookId'";
	$sqldelete = mysqli_query($conn, $sql);
	
	if($sqldelete){
			$Output = $BookId. " deleted";
		}
		else {
			$Output = $BookId. " not deleted";
			$Output = $Output  . "<br>" . mysqli_error($conn);
		}
	
}

//delete user 
if (isset($_POST['reject'])) {
	
	$Email = $_POST['email'];
	$sql = "Delete from tblusers WHERE email = '$Email'";
		$updateVstatus = mysqli_query($conn, $sql);
		if($updateVstatus){
			$Output = $Email. " rejected";
		}
		else {
			$Output = $Email. " not rejected";
			$Output = $Output  . "<br>" . mysqli_error($conn);
		}
		
}





?>
<!DOCTYPE html>
<html>

<head>
    <title></title>  
	<link rel="stylesheet" href="css/style.css">
	<style>
	.reject {
		border: none;
	  outline: 0;
	  padding: 12px;
	  color: white;
	  background-color: red;
	  text-align: center;
	  cursor: pointer;
	  width: 100%;
	  font-size: 18px;
	}

	.reject :hover {
	  opacity: 0.7;
	}

	.verify {
		border: none;
	  outline: 0;
	  padding: 12px;
	  color: white;
	  background-color: green;
	  text-align: center;
	  cursor: pointer;
	  width: 100%;
	  font-size: 18px;
	}

	.verify :hover {
	  opacity: 0.7;
	}
</style>
</head>

<body>
<center> <div class="headerBIO">Books.io</div></center>
<div class="topnav">
  <a  href="verifystudent.php">Verify user</a>
  <a  href="verifiedUser.php">Verified user</a>
  <a  class="active" href="adminViewBooks.php">View books</a>
  <a  href="adminAddBook.php">Add book</a>
  <a href="logout.php">logout</a>
</div>

<br><hr>
<h2> <?php echo $Output; ?></h2>

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
			 
			<form method = "post" action="" style="width:70%;">
			<input type="hidden" name ="Bookid" value="<?php echo $Bookid; ?>">
			<button type="submit" class="reject" name="removebook" >Remove</button>
			<br><br>
			<button type = "submit" class="addtocart" name="Update">Update</button><br>
			</form>
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