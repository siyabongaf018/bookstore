<?php

$tblusers = " CREATE TABLE `tblusers` (
  `uid` int(10) NOT NULL AUTO_INCREMENT,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `stnum` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `usertype` varchar(10) NOT NULL DEFAULT 'user',
  `vstatus` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";


$tblbooks = "CREATE TABLE `tblbooks` (
  `bookid` int(10) NOT NULL AUTO_INCREMENT,
  `bookTitle` varchar(50) NOT NULL,
  `category` varchar(50) NOT NULL,
  `image` varchar(50) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `qnty` int(10) NOT NULL,
  PRIMARY KEY (`bookid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

$tblorders = "CREATE TABLE `tblorders` (
  `oid` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) NOT NULL,
  `orderdate` date NOT NULL,
  PRIMARY KEY (`oid`),
  CONSTRAINT `tblorders_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `tblusers` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

$tblorderbooks = "CREATE TABLE `tblorderbooks` (
  `oid` int(10) NOT NULL,
  `bookid` int(10) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `qnty` int(10) NOT NULL,
  PRIMARY KEY (`oid`,`bookid`),
  CONSTRAINT `tblorderbooks_ibfk_1` FOREIGN KEY (`bookid`) REFERENCES `tblbooks` (`bookid`),
  CONSTRAINT `tblorderbooks_ibfk_2` FOREIGN KEY (`oid`) REFERENCES `tblorders` (`oid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

$createtableUser = mysqli_query($conn, $tblusers);
$createtableBooks = mysqli_query($conn, $tblbooks);
$createtableOrders = mysqli_query($conn, $tblorders);
$createtableOrderbooks = mysqli_query($conn, $tblorderbooks);

if($createtableUser && $createtableBooks && $createtableOrders && $createtableOrderbooks ){
	echo "<br>Tables created successfully<br>";
}
else{
	echo "<br>Tables already exist<br>";
}

$query = "SELECT * FROM tblusers";

		$result = mysqli_query($conn,$query);

		if (mysqli_num_rows($result) == 0) {
			
			loadUsersDataToTableUsers();
			loadBooksDataToTableBooks();
		}


function loadUsersDataToTableUsers(){
				global $conn;
				// Open the file for read data
				$openTxtFileUserData = fopen('userData.txt','r');
				
				//reading all the data from the textfiles
				while(!feof($openTxtFileUserData)){
					$getdata = fgets($openTxtFileUserData);
					$explodeLineWithUserData = explode(",",$getdata);
					list($fname,$Sname,$Stnum,$Email,$password) = $explodeLineWithUserData;
					$insertQuery = "insert into tblUsers(fname, lname, stnum, email, password) 
					values('$fname','$Sname','$Stnum','$Email','$password')";
					mysqli_query($conn,$insertQuery);
				} 
				fclose($openTxtFileUserData);
				
				$sql = "UPDATE tblusers SET usertype = 'admin', vstatus = b'1' WHERE email = 'siya@gmail.com'";
				$updateVstatus = mysqli_query($conn, $sql);
}
function loadBooksDataToTableBooks(){
				global $conn;
				// Open the file for read data
				$openTxtFileBookData = fopen('bookData.txt','r');

				//looping to read all the data from the textfiles
				while(!feof($openTxtFileBookData)){
					$getTextbookData = fgets($openTxtFileBookData);
					$explodeLineWithBooksDetails = explode(",",$getTextbookData);
					list($BookTitle,$category,$BookImage,$Bookprice,$quantity) = $explodeLineWithBooksDetails;
					$insertQuery = "insert into tblbooks(bookTitle, category, image,price,qnty) 
					values ('$BookTitle','$category','$BookImage','$Bookprice','$quantity')";
					mysqli_query($conn,$insertQuery);
				}
				fclose($openTxtFileBookData);  
}
?>
