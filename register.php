<?php 

include 'auth.php';

$timenow = time();

$username = $_POST['username'];
$password = $_POST['password'];

$query=mysqli_query($conn,"select * from freekey where username='$username'");
$cek=mysqli_num_rows($query);

if($cek > 0){
	echo "Registered";
}else{

if (isset($_POST["oneday"])) {
$EXPIREDDAYS = date("Y-m-d H:i:s", strtotime("+1 days", $timenow));
}elseif (isset($_POST["oneweek"])) { 
$EXPIREDDAYS = date("Y-m-d H:i:s", strtotime("+1 week", $timenow));
}elseif (isset($_POST["onemonth"])) { 
$EXPIREDDAYS = date("Y-m-d H:i:s", strtotime("+1 month", $timenow));
}

if($username == "" or $password == ""){
	echo "Empty";
	}elseif($username <>"" or $password <>""){
	$sql_simpan=mysqli_query($conn,"insert into freekey values('$username','$password','','$EXPIREDDAYS','2')");
 	echo "Success";
	} else {
 	echo "Failed";
	}
}

?>