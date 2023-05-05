<?php
session_start();
include('dbconn.php');

$BookTitle = $BookId = $Category = $imageURL = $BookPrice= $Quantity = $output =  null;
$error =0;

if(!isset($_SESSION['email'])){
    header("location:index.php");
}

if(isset($_POST['submit']))
{
    header("location:login.php");
    unset($_SESSION['email']);  
    session_destroy(); 
}

if(isset($_POST["AddBook"])) {
	
	$target_dir= "images/";
	$target_file = $target_dir . basename($_FILES["imageToUpload"]["name"]);
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

	
	$BookTitle = $_POST["BookTitle"];
	$Category = $_POST["category"];
	$BookPrice= $_POST["BookPrice"];
	$Quantity = $_POST["Quantity"];
	
	if(empty($BookTitle)){
	$output = "Book Title is empty";
	$error =1;
	}
	
	if(empty($Category)){
	$output = "Category is empty";
	$error =1;
	}
	
	if(empty($BookPrice)){
		$output = "Book Price is empty";
		$error =1;
	}
	if(empty($Quantity)){
		$output = "Quantity is empty";
		$error =1;
	}
	
  $check = getimagesize($_FILES["imageToUpload"]["tmp_name"]);
  if($check !== false) {
    $output = "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    $output = "File is not an image.";
    $uploadOk = 0;
  }


	// Check if file already exists
	/*if (file_exists($target_file)) {
	  echo "Sorry, file already exists.";
	  $uploadOk = 0;
	}*/

	// Check file size
	if ($_FILES["imageToUpload"]["size"] > 5000000) {
	  $output = "Sorry, your file is too large.";
	  $uploadOk = 0;
	  $error =1;
	}

	

	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" ) {
	  $output = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
	  $uploadOk = 0;
	  $error =1;
	}

	// Check if $uploadOk is set to 0 by an error
	else if ($uploadOk == 0) {
	  $output = "Sorry, your file was not uploaded.";
	  $error =1;
	// if everything is ok, try to upload file
	} else {
	  if (move_uploaded_file($_FILES["imageToUpload"]["tmp_name"], $target_file)) {
		$imageURL =  "\images/".htmlspecialchars( basename( $_FILES["imageToUpload"]["name"]));
	 
	  
	  } else {
		$output = "<br>Sorry, there was an error uploading your file.";
	  }
	}

	if($error ==0){
		
		$sqlAddBook = "";
		$insertQuery = "insert into tblbooks(bookTitle, category, image,price,qnty) 
						values ('$BookTitle','$Category','$imageURL','$BookPrice','$Quantity')";
		$createtableUser = mysqli_query($conn,$insertQuery);
		
		
		if($createtableUser){
			echo '<script>alert("Book Added")</script>';
			$BookTitle = $Category = $BookPrice = $Quantity = null;
			//header("Location: adminAddBook.php");
		}else{
			echo "".mysql_error($conn);
		}
	}
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
  <a  href="verifystudent.php">Verify user</a>
  <a  href="verifiedUser.php">Verified user</a>
  <a  href="adminViewBooks.php">View books</a>
  <a  class="active" href="adminAddBook.php">Add book</a>
    <a href="logout.php">logout</a>
</div>

<form method="post" action="" enctype="multipart/form-data">
<center><h2>Add book</h2></center>
<center><h2><?php echo $output;?></h2></center>
		<table class="table">
			<tr>
				<th>Book Title:</th>
				<td><input type="text" name="BookTitle" value="<?php echo $BookTitle;?>" required></td>
			</tr>
			<tr>
				<th>Category</th>
				<td><input type="text" name="category" value="<?php echo $Category;?>" required></td>
			</tr>
			<tr>
				<th>Book Price</th>
				<td><input type="number" min="0.00" max="10000000.00" step="0.01" id="BookPrice" name="BookPrice" value = "<?php echo $BookPrice;  ?>" required></td>
			</tr>
			
			<tr>
				<th>Quantity</th>
				<td><input type="number" id="Quantity" name="Quantity" value = "<?php echo $Quantity;  ?>"></td>
			</tr>
			
			<tr>
				<th>Image</th>
				<td><input type="file" name="imageToUpload" required></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" name="AddBook" value="Add book" class="btn btn-primary"></td>
			</tr>
			
			
		</table>
		
	</form>
	<!--
		<input type="submit" name="save_change" value="Add" class="btn btn-primary">
		<input type="reset" value="clear" class="btn btn-default">
	-->


</body>
</html>