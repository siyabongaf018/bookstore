
<?php

session_start();
include "DBConn.php";


$Output = null;
If(!isset($_SESSION['email']))
{
	header('location:login.php');
}

//approve user 
if (isset($_POST['Approve'])) {
	
	$Email = $_POST['email'];
	
	//$sql = "UPDATE tblusers SET vstatus = b\'1\' WHERE email = '$Email'";
	$sql = "UPDATE tblusers SET vstatus = b'1' WHERE email = '$Email'";
		$updateVstatus = mysqli_query($conn, $sql);
		if($updateVstatus){
			$Output = $Email. " verified";
		}
		else {
			$Output = $Email. " not verified";
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

<!DOCTYPE>
<html>
<head>
<title>
</title>
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
<HR>

<div class="topnav">
  <a class="active" href="verifystudent.php">Verify user</a>
  <a href="verifiedUser.php">Verified user</a>
  <a href="adminViewBooks.php">View books</a>
  <a  href="adminAddBook.php">Add book</a>
    <a href="logout.php">logout</a>
  
</div>
<br><hr>

<div style="padding-left:16px">
  <h2><?php echo $Output;?></h2>
  
  
</div>
 

 <table border="1" cellspacing="2" cellpadding="5">
            <tr>
            <td><b>First Name</b></td>
            <td><b>Surname</b></td>
			<td><b>Student Number</b></td>
			<td><b>Email</b></td>
			<td><b>Verify</b></td>
			<td><b>Reject</b></td>
        </tr>
<?php
// Include the database configuration file
include('dbconn.php');
$fname = $Sname = $Stnum = $Email = $usertype = $uid = null;
// Get images from the database

$sql = "SELECT * FROM tblUsers where vstatus ='0'";
$query = mysqli_query($conn,$sql);

if(mysqli_num_rows($query) > 0){
    while($row = mysqli_fetch_assoc($query)){
		$uid = $row["uid"];
        $fname = $row["fname"];
        $Sname = $row["lname"];
		$Stnum = $row["stnum"];
		$Email = $row["email"];
        $usertype = $row["vstatus"];
?>
    <tr>
	
    <td>
    <p><?php echo $fname; ?></p>
    </td>
	
	<td>
    <p><?php echo $Sname; ?></p>
    </td>
	
	<td>
    <p><?php echo $Stnum; ?></p>
    </td>
	
	<td>
    <p><?php echo $Email; ?></p>
    </td>
	
	<td> 
	<form action="" method="post">
        <input type="hidden" name ="email" value="<?php echo $Email; ?>">
        <button class= "verify" type='submit' name= 'Approve' >Approve</button>
    </form>
	
    </td>
	
	<td> 
	<form action="" method="post">
        <input type="hidden" name ="email" value="<?php echo $Email; ?>">
        <button  class= "reject" type='submit' name= 'reject' >Reject</button>
    </form>
	
    </td>
	
    </tr>
<?php }

}else{ ?>
    <p>No unverified user</p>
<?php } ?>
</table>



</body>

</html>
