<?php
session_start(); 
$DB_HOST = "localhost";
$DB_NAME= "project_silver";
$USER = "root";
$PASS = "";
try {
    $db = new PDO("mysql:host=" . $DB_HOST. ";dbname=" . $DB_NAME , $USER, $PASS);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'A database error occured when loading Project Silver.' ;
    exit;
}
?>
