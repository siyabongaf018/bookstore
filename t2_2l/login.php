<?php
session_start();
include "DBConn.php";
include "createTable.php";
unset($_SESSION['email']);
$Email = $password = $Stnum =  $hashpassoword =  $output = $count = null;

$role = $verify =  $results = null;
 $error = 0;
 /*$Email = $_SESSION["email"] ;
 $hashpassoword = $_SESSION["passoword"];*/


if(isset($_POST['login'])){
	
	
	$Email = $_POST['email'];
	$Stnum = $_POST['stnumber'];
	$password = $_POST['password'];
	
	if(empty($Email)){
	$output = "Email is empty";
	$error =1;
	}
	
	if(empty($Stnum)){
	$output = "Student number is empty";
	}
	
	if(empty($password)){
		$output = "Password is empty";
	}
	
	if ($error == 0) {
  	$password = md5($password);
  	$query = "SELECT * FROM tblusers WHERE email = '$Email' AND stnum ='$Stnum' AND password='$password' ";
  	$results = mysqli_query($conn, $query);
	
		if (mysqli_num_rows($results) == 1) {
			$user =mysqli_fetch_array($results);
				$role = $user["usertype"];
				$verify = $user['vstatus']; 
				
				if($verify == 1){
					if ($role=="user"){
						$_SESSION['email'] = $Email;
						header('location: index.php');
					}elseif($role=="admin"){
						$_SESSION['email'] = $Email;
						header('location: verifystudent.php');
					}
				}
				else {
					$output = $Email . " Request panding";
				}
		
		 
		}
		else {
			$output ="Wrong username/password combination ";
		}
	}
	
	
	
	
	
}
	
	


?>

<!DOCTYPE html>
<html>
<head>
<title>

</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>


<form action="" method="post">
  <?php echo $output. "<br>"; ?>
  <div class="split left">
  <div class="centered">
  <h1 style="color:White; font-size: 150px;">Books.oi <br> Login
  
  </h1>
    
    

  </div>
</div>

<div class="split right">
  <div class="centered">
   
  <div class= "input-group"> 
  <label for="email">Admin Login details Usernm:siya@gmail.com STNumber:ST10131002  Pass:Obese\towny5</label><br>
  <hr>
  </div> 
  
  <div class= "input-group"> 
  <label for="email">Email:</label><br>
  <input type="email" id="lname" name="email" value = "<?php echo $Email;  ?>"><br>
  </div> 
  
  <div class= "input-group"> 
  <label for="stnumber">Student number:</label><br>
  <input type="text" id="stnumber" name="stnumber" value = "<?php echo $Stnum;  ?>"  ><br>
  </div> 
  
  <div class= "input-group"> 
  <label for="password">Password:</label><br>
  <input type="password" id="password" name="password" value = ""><br><br>
  </div> 
   <button type = "submit" class="btn" name="login">login</button><br>
   <label >Not a member? <a href="register.php">Register</a>  </label><br>
  
  	<?php echo $output; ?>

    </div>
</div>
</form>
<?php
echo $Email . "<br>";
echo $hashpassoword . "<br>count: ";
echo $count . "<br>";
echo "<br>errors: " .$error ;

echo "<br>v role: ". $role ;
echo "<br>v status: ". $verify;


?>



</body>

</html>