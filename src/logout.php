<?php
require_once("inc/db.php");
if(isset($_SESSION['token'])){
    session_unset();
    header("Location: /");
}else{
    header("Location: /");
}