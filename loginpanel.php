<?php 

include 'auth.php';

$username = $_POST['username'];
$password = $_POST['password'];

$login = mysqli_query($conn,"select * from freekey where username='$username' and password='$password'");
$cek = mysqli_num_rows($login);

if($cek > 0){
	$data = mysqli_fetch_assoc($login);
	
	echo "Success";
	echo "\n";
	echo "【username】";
    echo ($data["username"]);
    echo "【username】";
    echo "\n";
    echo "【password】";
    echo ($data["password"]);
    echo "【password】";
    echo "\n";
    echo "【uuid】";
    echo ($data["uuid"]);
    echo "【uuid】";
    echo "\n";
    echo "【expDate】";
    echo ($data["expDate"]);
    echo "【expDate】";

}else{
	echo "Username and Password is not in the list!";
}

?>