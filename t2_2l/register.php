
<?php


$fname = $Sname = $Stnum = $Email = $password = $CPassword = $output = $hashpassoword = null;
// Validate password strength
$uppercase = $lowercase = $number    = $specialChars = null;

$result = null;
session_start();
include "dbconn.php";
if(isset($_POST['register']))
{
	$fname =$_POST['fname'];
	$Sname=$_POST['sname'];
	$Stnum=$_POST['stnumber'];
	$Email=$_POST['email'];
	$password=$_POST['password'];
	$CPassword =$_POST['cpassword'];


	$usercheck = "select * from tblusers where email like '$Email' OR stnum like '$Stnum' LIMIT 1";
	$result = mysqli_query($conn, $usercheck);
	$user =mysqli_fetch_assoc($result);

	//FORM VALIDATION 
	// Validate password strength
	$uppercase = preg_match('@[A-Z]@', $password);
	$lowercase = preg_match('@[a-z]@', $password);
	$number    = preg_match('@[0-9]@', $password);
	$specialChars = preg_match('@[^\w]@', $password);

	if(empty($fname)){
		$output = "Name is empty";
	}elseif(empty($Sname)){
		$output = "Surname is empty";
	}elseif(empty($Stnum)){
		$output = "Student number is empty";
	}elseif(empty($Email)){
		$output = "Email is empty";
	}elseif(empty($password)){
		$output = "Password is empty";
	}elseif(empty($CPassword)){
		$output = "Confirm password is empty";
	}
	//length of student number
	elseif(strlen($Stnum) >10){
		$output = "Student number is must have 10 characters";
	}

	//email validation 
	elseif(!filter_var($Email, FILTER_VALIDATE_EMAIL)){
		//$output = "Confirm password is empty";
	}

	
	elseif(!$uppercase || !$lowercase || !$number || !$specialChars){
		$output = "Passwords should include at least one upper case letter, one number, and one special character";
	}

	elseif($password !== $CPassword){
		$output = "Passwords dont match";
	}

	elseif(strlen($password) <8 ){
		$output = "Passwords is too short";
	}
	elseif(($user['email'] === $Email) || ($user['studentnumber'] === $Stnum) ){
		$output = "User already exist";
	}
	
	else{
		$hashpassoword = md5($password);
		
		echo "-------";
			$sql = "INSERT INTO tblusers (fname,lname,stnum,email,password) 
			VALUES ('$fname','$Sname','$Stnum','$Email','$hashpassoword')";
			$insert= mysqli_query($conn,$sql);
			
			
			if($insert){
				$output = "Row inserted";
				$_SESSION["email"] = $Email;
				$_SESSION["passoword"] = $hashpassoword;
				
				$fname = $Sname = $Stnum = $Email = null;
				
				//$_SESSION["output"] = "Row inserted";
				header ('location: login.php');
				
				
			}
			else{
				$output = "Row not inserted";
				//$_SESSION["output"] = "Row not inserted";
			}
		
	}


		// Close connection
			mysqli_close($conn);
			
		
}
?>


<html>
<head>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<h3 class = "head"> Register</h3>

<form action="Register.php" method="post">
<?php echo $output; ?>
<div class="split left" style="background-image: url('pixelcover2.jpg; background-size: auto'); >
<h1 style="color:White; font-size: width="150px";"> Books.oi </h1>
  <div class="centered">
  <h1 style="color:White; font-size: 150px;">Books.oi <br> Register
  
  </h1>
    
    

  </div>
</div>
<div style="color:#666363;">
  <div class="centered">
  
    

  <h1 >
  
  
  </h1>
    

  </div>
</div>

<div class="split right">
  <div class="centered">
   
<center>

<div class= "input-group">
  <label >Name:</label>
  <input type="text" id="fname" name="fname" value = "<?php echo $fname;  ?>" ><br>
</div> 

<div class= "input-group">
  <label for="sname">Surname:</label><br>
  <input type="text" id="sname" name="sname" value = "<?php echo $Sname;  ?>" ><br>
 </div>
<div class= "input-group"> 
  <label for="stnumber">Student number:</label><br>
  <input type="text" id="stnumber" name="stnumber" value = "<?php echo $Stnum;  ?>"  ><br>
</div>  

<div class= "input-group"> 
  <label for="email">Email:</label><br>
  <input type="email" id="lname" name="email"  value = "<?php echo $Email;  ?>" ><br>
 </div> 
 
<div class= "input-group">
  <label for="password">Password:</label><br>
  <input type="password" id="password" name="password" value = "<?php echo $password;  ?>"  ><br>
</div> 

<div class= "input-group"> 
  <label for="cpassword">Confirm password:</label><br>
  <input type="password" id="cpassword" name="cpassword"  ><br>
</div> 

<div class= "input-group"><br>
   <button class = "btn" type = "submit"class="btn" name="register">Register</button><br>
   <label >Already a member? <a href="login.php">Login</a>  </label><br>
   
   <?php echo $output; ?>
</div>   
</center>
</div>  
</div> 
</form>

<?php

//echo "result: " . $result;


?>



</body>

</html>