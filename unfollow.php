<?php
session_start();
if($_SESSION['status']!="login"){
    header("location:login.php");
}
include("config.php");
$id = $_GET[username];
$myid = $_SESSION['id'];
$perintah = $db->query("DELETE FROM friend WHERE user_id = '$myid' AND friend_id = '$id'");
if ($perintah == true) {
    header("location:user.php?username=$id");
}else{

    echo $myid;

    echo $id;
}
?>