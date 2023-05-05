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

$BookTitle = $BookId = $Category = $imageURL = $textBookSellPrice= $Quantity =  null;

$error = 0 ;

$BookIdCart= null;


// set a session variable 
if (!isset($_SESSION['cart'])) {
	# code...
	$_SESSION['cart']='';
}

if(isset($_SESSION['bookid'])){
$BookId = $_SESSION['bookid'];


$sql = "SELECT * FROM tblbooks where bookid ='$BookId'";
$query = mysqli_query($conn,$sql);

//retriving books details from the database
if(mysqli_num_rows($query) > 0){
	$result = mysqli_fetch_assoc($query);
    $textBookSellPrice = $result["price"];
	$textBookQuantity = $result["qnty"];
}

// checking if the session variable is empty or not
	if (!empty($_SESSION['cart'])){ 
		// count the session array varible 
		 $max=count($_SESSION['cart']); 

		 // segregating session array variable.
	   	 for($i=0;$i<$max;$i++){
	   	 	// checking if the item does exist
	      if($BookId==$_SESSION['cart'][$i]['PRODUCTID']){  

	      	$exist = 1;
	      
	      } 
	     }
	     	// confirming the item if it does not exist.
		     if (!isset($exist)) {
		     	# code...
		     	// adding the item in the session array variable
		     	if(is_array($_SESSION['cart'])){
					$max=count($_SESSION['cart']);
					$_SESSION['cart'][$max]['PRODUCTID']=$BookId;  
					$_SESSION['cart'][$max]['PRICE']=$textBookSellPrice;
					$_SESSION['cart'][$max]['QUANTITY']=1;  
				}else{
					$_SESSION['cart']=array();
					$_SESSION['cart'][0]['PRODUCTID']=$BookId;  
					$_SESSION['cart'][0]['PRICE']=$textBookSellPrice; 
					$_SESSION['cart'][0]['QUANTITY']=1;  
				}  
		     }else{
		     // return false.
		     	 ?> 
					<script type="text/javascript">
						// 	<!-- Pop-up Message  -->
						alert('Item is already in the cart.')
						// <!-- End pop-up message -->
						// redirect to main page.
						//window.location='cart.php'
						// end redirect
					</script> 
				<?php

		     }
				
		
		}else{
			// adding the item in the session array variable
			$_SESSION['cart']=array();
			$_SESSION['cart'][0]['PRODUCTID']=$BookId;  
			$_SESSION['cart'][0]['PRICE']=$textBookSellPrice; 
			$_SESSION['cart'][0]['QUANTITY']=1;  
		
     } 





}



function total_price($cart){
		$price = 0.0;
		if(is_array($cart)){
		  	foreach($cart as $isbn => $qty){
		  		$bookprice = $textBookSellPrice;
		  		if($bookprice){
		  			$price += $bookprice * $qty;
		  		}
		  	}
		}
		return $price;
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
  <a href="index.php">Home</a>
  <a href="viewbooks.php">View books</a>
  <a href="aboutUs.php">About Us</a>
  <a class="active" href="cart.php">My cart</a>
  <a href="logout.php">Logout</a>
</div>
<br><hr>
<?php echo $BookId;?>
<br>
<form method = "post" action="" style="width:70%;">

<table border="0" cellspacing="1" cellpadding="2" style="width:100%">
	<tr>
		<td><b>Cover Page:</b></td>
		<td><b>Book Title:</b></td> 
		<td><b>Category:</b></td> 
		<td><b>Book Price:</b></td> 
		<td><b>Quantity:</b></td> 
		<td><b>Remove Book:</b></td>
	</tr>
	<?php 
	if (isset( $_SESSION['janobecart'])){
	   $count_cart = count($_SESSION['janobecart']);
	   for ($i=0; $i < $count_cart  ; $i++) {
		   
		   $Bookid = $_SESSION['janobecart'][$i]['PRODUCTID'];
		   $qty = $_SESSION['janobecart'][$i]['QUANTITY'];
			$subtot = $_SESSION['janobecart'][$i]['PRICE'];

			$sql = "SELECT * FROM tblbooks where bookid ='$BookId'";
			//$query = mysqli_query($conn,$sql);
			$result = mysqli_query($conn,$sql) or die(mysql_error());

			while ($row = mysql_fetch_array($result)) {
				$imageURL = $result["image"];
				$textBookTitle = $result["bookTitle"];
				$category = $result["category"];
				$textBookSellPrice = $result["price"];
				
			?><tr>
				<td> <img src="<?php echo $imageURL; ?>" alt="" /> </td>
				<td> <?php echo $textBookTitle; ?> </td>
				<td> <?php echo $category; ?> </td>
				<td> <span style="color:rgb(70, 218, 25);" > <?php echo "<b>R </b>".$textBookSellPrice; ?></span> </td>
				<td> <input type="input" class=""  name="qty'.$proid.'" value='. $qty.'  maxlength="3" size="3"  />
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
			<?php
			}
	   }
	
	}
	?>
	<tr>
		<input type="submit" class=""  name="Update" value="Update" />
	</tr>
	

</table>

</form>


</body>
</html>