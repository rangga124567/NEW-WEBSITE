<?php 

include 'auth.php';

$username= $_POST['username'];
$password= $_POST['password'];
$uuid= $_POST['uuid'];

$EXPIRE = date('Y-m-d H:i:s');

$login = mysqli_query($conn,"select * from freekey where username='$username' and password='$password'");
$cek = mysqli_num_rows($login);
if($cek > 0){
$data = mysqli_fetch_assoc($login);
if($data["status"] == 1){
$delete=mysqli_query($conn,"DELETE FROM freekey
WHERE username = '$username'");
echo "Success";
}elseif ($data["status"] == 2){
if($EXPIRE > $data["expDate"]){
echo "Expired";
}else{
if($data["uuid"] == NULL){
$query = $conn->query("UPDATE freekey SET uuid= '$uuid', expDate= '".$data["expDate"]."' WHERE username='$username' and password = '$password'");
echo "Success";
echo "\n";
echo ";";
echo ($data["expDate"]);
echo ";";
}elseif ($data["uuid"] !== $uuid){
echo "Device changed";
}else{
echo "Success";
echo "\n";
echo ";";
echo ($data["expDate"]);
echo ";";
}
}
}
}else{
	echo "Username and Password is not in the list!";
}
?>