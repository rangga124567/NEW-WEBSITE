<?php 

$dbhost = 'sql300.infinityfree.com';
$dbuser = 'if0_36732168';
$dbpass = 'oKqdfW5M8SbSB';
$db = 'if0_36732168_Manchester';
$conn = mysqli_connect($dbhost, $dbuser, $dbpass , $db) or die($conn); 

date_default_timezone_set('Asia/Jakarta');

if (mysqli_connect_error()){
	echo "Koneksi database gagal :". mysqli_connect_error();
}

?>