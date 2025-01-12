<?php

include 'init.php';

//initialization
$crypter = Crypter::init();
$privatekey = readFileData("Keys/PrivateKey.prk");

function tokenResponse($data){
    global $crypter, $privatekey;
    $data = toJson($data);
    $datahash = sha256($data);
    $acktoken = array(
        "Data" => profileEncrypt($data, $datahash),
        "Sign" => toBase64($crypter->signByPrivate($privatekey, $data)),
        "Hash" => $datahash
    );
    return toBase64(toJson($acktoken));
}

//token data
$token = fromBase64($_POST['token']);
$tokarr = fromJson($token, true);

//Data section decrypter
$encdata = $tokarr['Data'];
$decdata = trim($crypter->decryptByPrivate($privatekey, fromBase64($encdata)));
$data = fromJson($decdata);

//Hash Validator
$tokhash = $tokarr['Hash'];
$newhash = sha256($encdata);

if (strcmp($tokhash, $newhash) == 0) {
    PlainDie();
}

if($maintenance){
    $ackdata = array(
        "Status" => "Failed",
        "MessageString" => "Server is in maintenance.",
        "SubscriptionLeft" => "0"
    );
    PlainDie(tokenResponse($ackdata));
}

//username Validator
$username = $data["username"];
if($username == null){
    $ackdata = array(
        "Status" => "Failed",
        "MessageString" => "Username invalid.",
        "SubscriptionLeft" => "0"
    );
    PlainDie(tokenResponse($ackdata));
}

//password Validator
$password = $data["password"];
if($password == null){
    $ackdata = array(
        "Status" => "Failed",
        "MessageString" => "Password invalid.",
        "SubscriptionLeft" => "0"
    );
    PlainDie(tokenResponse($ackdata));
}

$query = $conn->query("select * from tmhs where username='".$username."'");
if($query->num_rows < 1){
    $ackdata = array(
        "Status" => "Failed",
        "MessageString" => "Username not resgistered.",
        "SubscriptionLeft" => "0"
    );
    PlainDie(tokenResponse($ackdata));
}

$res = $query->fetch_assoc();
if($res["password"] != $data["password"]){
    $ackdata = array(
        "Status" => "Failed",
        "MessageString" => "Password invalid.",
        "SubscriptionLeft" => "0"
    );
    PlainDie(tokenResponse($ackdata));
}

if($res["userType"] != "membership"){
$delete=mysqli_query($conn,"DELETE FROM tmhs WHERE username = '".$username."'");
    $ackdata = array(
        "Status" => "Success",
        "MessageString" => "Login success.",
        "SubscriptionLeft" => "0"
    );
    PlainDie(tokenResponse($ackdata));
}

if($res["uuid"] == NULL){
$update = $conn->query("UPDATE tmhs SET uuid= '".$data["uuid"]."', expDate= '".$res["expDate"]."' WHERE username='$username'");
} else if($res["uuid"] != $data["uuid"]) {
    $ackdata = array(
        "Status" => "Failed",
        "MessageString" => "UUID invalid.",
        "SubscriptionLeft" => "0"
    );
    PlainDie(tokenResponse($ackdata));
}

date_default_timezone_set('Asia/Jakarta');
$timenow = time();
$EXPIRE = date('Y-m-d H:i:s');
$EXPIREDDAYS = date("Y-m-d H:i:s", strtotime($res["expType"], $timenow));
if($res["expDate"] == "0000-00-00 00:00:00"){
$update = $conn->query("UPDATE tmhs SET expDate= '$EXPIREDDAYS' WHERE username='$username'");
}else if($EXPIRE > $res["expDate"]){
    $ackdata = array(
        "Status" => "Failed",
        "MessageString" => "Username expired.",
        "SubscriptionLeft" => "0"
    );
    PlainDie(tokenResponse($ackdata));
}

$query = $conn->query("select * from tmhs where username='".$username."'");
$res = $query->fetch_assoc();
$EXPIREDSTRING = number_format(strtotime($res["expDate"])*1000, 0, '.', '');
$ackdata = array(
    "Status" => "Success",
    "MessageString" => "Login success.",
    "SubscriptionLeft" => $EXPIREDSTRING
);

echo tokenResponse($ackdata);