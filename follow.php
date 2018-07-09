<?php
session_start();
if($_SESSION['status']!="login"){
    header("location:login.php");
}
include("config.php");
$username = $_GET[username];
$myid = $_SESSION['id'];
$sqlid = $db->query("SELECT * FROM user WHERE username = '$username'");
$row = mysqli_fetch_array($sqlid);
$perintah = $db->query("INSERT INTO friend(user_id,friend_id) VALUES ('$myid','$username')");
if ($perintah == true) {
    header("location:user.php?username=$id");
}else{

    echo $myid;

    echo $id;
}
?>