<?php

include 'auth.php';

$username=$_POST['username'];

$query=mysqli_query($conn,"select * from freekey where username='$username'");
$cek=mysqli_num_rows($query);

if($cek > 0){

if($username == "" ){
	echo "Empty";
	}elseif($username <>""){
$delete=mysqli_query($conn,"DELETE FROM freekey
WHERE username = '$username'");
	if ($delete){
 	echo "Success";
 }else{
echo "Failed!"; 
 }
	}
}else{
echo "Username Empty";
}

?>