<?php

session_start();
include "DBConn.php";

$BookTitle = $Category = $imageURL = $BookPrice = $Quantity = $output=  null;
$error =0;


$target_dir = "images/";
$target_file = $target_dir . basename($_FILES["imageToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));


// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
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
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
}

// Check if file already exists
if (file_exists($target_file)) {
  echo "Sorry, file already exists.";
  $uploadOk = 0;
}

// Check file size
if ($_FILES["imageToUpload"]["size"] > 5000000) {
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
}

echo "<br> file type".$imageFileType."<br>";

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
  $error =1;
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["imageToUpload"]["tmp_name"], $target_file)) {
    $imageURL =  "images\\".htmlspecialchars( basename( $_FILES["imageToUpload"]["name"]));
  //<script> alert("The file ". htmlspecialchars( basename( $_FILES["imageToUpload"]["name"])). " has been uploaded.");</script>
  echo "<br>".$imageURL;
  } else {
    echo "<br>Sorry, there was an error uploading your file.";
  }
}


echo "<br>error".$error;
if($error ==0){
	$sqlAddBook = "";
	$insertQuery = "insert into tblbooks(bookTitle, category, image,price,qnty) 
					values ('$BookTitle','$Category','$imageURL','$BookPrice','$Quantity')";
	$createtableUser = mysqli_query($conn,$insertQuery);
	
	echo "<br>sql query ".$insertQuery;
	
	echo "<br>boolean ".$createtableUser;
	
	if($createtableUser){
		echo '<script>alert("Welcome to Geeks for Geeks")</script>';
		header("Location: adminAddBook.php");
	}else{
		echo "".mysql_error($conn);
	}
}
?>
