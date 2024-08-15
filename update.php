<?php 

include 'auth.php';

$timenow = time();

$username = $_POST['username'];
$password = $_POST['password'];
$uuid = $_POST['uuid'];

$login = mysqli_query($conn,"select * from freekey where username='$username' and password='$password'");
$cek = mysqli_num_rows($login);

if($cek > 0){

$data = mysqli_fetch_assoc($login);

if (isset($_POST["oneday"])) {
$EXPIREDDAYS = date("Y-m-d H:i:s", strtotime("+1 days", $timenow));
}elseif (isset($_POST["oneweek"])) { 
$EXPIREDDAYS = date("Y-m-d H:i:s", strtotime("+1 week", $timenow));
}elseif (isset($_POST["onemonth"])) { 
$EXPIREDDAYS = date("Y-m-d H:i:s", strtotime("+1 month", $timenow));
}else{
$EXPIREDDAYS = ($data["expDate"]);
}

$sql_update=mysqli_query($conn,"UPDATE freekey SET uuid='$uuid',expDate='$EXPIREDDAYS',status='2' WHERE username='$username' and password='$password'");
echo "Success";
}else{
	echo "Username and Password is not in the list!";
}

?>