<?php
session_start();


if($_SESSION['status']!="login"){
    header("location:login.php");
}

if ($_SESSION['role']!="admin"){
    header("location:index.php");
}

include("config.php");
$id = $_GET[id];
$perintah = $db->query("DELETE FROM user WHERE id = '$id'");
if ($perintah == true) {
    header("location:admin.php");
}else{

    echo $myid;

    echo $id;
}
?>