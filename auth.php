<?php 

$dbhost = 'localhost';
$dbuser = 'fluidmod_shooter';
$dbpass = '7uqfM}0I)G8u';
$db = 'fluidmod_shooter';
$conn = mysqli_connect($dbhost, $dbuser, $dbpass , $db) or die($conn); 

date_default_timezone_set('Asia/Jakarta');

if (mysqli_connect_error()){
	echo "Koneksi database gagal :". mysqli_connect_error();
}

?>