<?php
if(strpos($_SERVER['REQUEST_URI'],"DB.php")){
    require_once 'Utils.php';
    PlainDie();
}

$conn = new mysqli("localhost", "fluidmod_shooter", "7uqfM}0I)G8u", "fluidmod_shooter");
if($conn->connect_error != null){
    die($conn->connect_error);
}