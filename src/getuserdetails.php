<?php
//libs
require_once "inc/db.php";

header("Content-Type: application/json");
if(!isset($_GET['token'])){
    echo '{"success":0, "errorMsg":"TOKEN_NOT_RECEIVED"}';
    exit;
}
$request = $db->prepare("SELECT * FROM `tokens` WHERE `token`=:token");
$request->execute([
    "token" => $_GET['token']
]);
$result = $request->fetch();
if($result != true){
    echo '{"success":0, "errorMsg":"TOKEN_NOT_VALID"}';
    exit;
}
$request = $db->prepare("SELECT * FROM `users` WHERE `id`=:id");
$request->execute([
    "id" => $result['forid']
]);
$result = $request->fetch();
$array = array("id" => $result['id'], "username" => $result['username'], "email" => $result['email']);
$encodedarray = json_encode($array, JSON_PRETTY_PRINT);
echo $encodedarray;
?>