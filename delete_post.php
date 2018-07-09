<?php
session_start();
if($_SESSION['status']!="login"){
    header("location:login.php");
}
include("config.php");
$id = $_GET[post];
$perintah = $db->query("DELETE FROM status WHERE s_id = '$id'");
if ($perintah == true) {
    header("location:user.php?username=$id");
}else{

    echo $myid;

    echo $id;
}
?>