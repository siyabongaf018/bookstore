<?php

$server = 'localhost';
$user = 'root';
$password = '';
$dbname = 'bookstore';

$conn = mysqli_connect($server,$user, $password );
 
/*mysqli_connect() establishes datdabase connection 
connect to wamp server
return true or false
*/
echo "<br>";
if(!$conn){
	die('could nt connect: ' . mysqli_error());
}
else {
	//echo "YOU HAVE SUCCESSFULLY CONNECTED $dbname"; 
}
$selectDB = mysqli_select_db($conn, $dbname ); //return true if the database exist and false if it dousent exist
echo "<br>";
if(!$selectDB){
	$sql = "create database ". $dbname . "";
	$createdb = mysqli_query($conn, $sql);
	//echo "Database $dbname created succesfully";

}
else {
	//echo "Database exist";
}

$conn = mysqli_connect($server,$user, $password , $dbname );

function databaseConnection(){
		$conn = mysqli_connect('localhost','root', '' , 'bookstore' );
		if(!$conn){
			echo "Can't connect database " . mysqli_connect_error($conn);
			exit;
		}
		return $conn;
	}

?>