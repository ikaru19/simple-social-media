
<?php

session_start();


if($_SESSION['status']!="login"){
    header("location:login.php");
}
include("config.php");

if (isset($_POST['submit_edit'])) {
    $ekstensi_diperbolehkan = array('png', 'jpg');
    $nama = $_FILES['file']['name'];
    $x = explode('.', $nama);
    $ekstensi = strtolower(end($x));
    $ukuran = $_FILES['file']['size'];
    $file_tmp = $_FILES['file']['tmp_name'];
    if ($nama!=null) {
        if (in_array($ekstensi, $ekstensi_diperbolehkan) === true) {
            if ($ukuran < 1044070) {
                move_uploaded_file($file_tmp, 'img/' . $nama);
                $id = $_SESSION['id'];
                $username = $_POST['username'];
                $fname = $_POST['fname'];
                $lname = $_POST['lname'];
                $bio = $_POST['bio'];
                $email = $_POST['email'];
                $perintah = $db->query("UPDATE user SET username ='$username',fname ='$fname' , lname = '$lname' , bio = '$bio' , email = '$email' , picture = '$nama' WHERE id='$id'");

                if ($perintah == true) {
                    $username = $_SESSION['username'];

                    header("location:user.php?username=$username");
                } else {
                    printf("Errormessage: %s\n", $db->error);
                }
            } else {
                echo 'UKURAN FILE TERLALU BESAR';
            }
        } else {
            echo 'EKSTENSI FILE YANG DI UPLOAD TIDAK DI PERBOLEHKAN';
        }
    }else{
        $id = $_SESSION['id'];
        $username = $_POST['username'];
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $bio = $_POST['bio'];
        $email = $_POST['email'];
        $perintah = $db->query("UPDATE user SET username ='$username',fname ='$fname' , lname = '$lname' , bio = '$bio' , email = '$email'  WHERE id='$id'");

        if ($perintah == true) {
            $username = $_SESSION['username'];

            header("location:user.php?username=$username");
        } else {
            printf("Errormessage: %s\n", $db->error);
        }
    }
}



?>
<html>
<head>
    <title>weCon</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/AdminLTE.min.css">

</head>
<body>
<header>
    <nav class="navbar navbar-expand-md navbar-dark " style="background: #1abc9c;">
        <div class="collapse navbar-collapse row" style="font-size: 25px;">

            <div class="col-10">
                <ul class="navbar-nav">
                    <li class="nav-item "><a href="index.php" data-toggle="tooltip" title="Home" class="nav-link"><i class="fa fa-home" aria-hidden="true"></i>
                        </a></li>
                    <li class="nav-item"><a href="explore.php"  data-toggle="tooltip" title="Explore" class="nav-link"><i class="fa fa-compass" aria-hidden="true"></i>
                        </a></li>
                    <li class="nav-item"><a href="friend.php" data-toggle="tooltip" title="Friends" class="nav-link"><i class="fa fa-users" aria-hidden="true"></i>
                        </a></li>

                    <?php
                    if ($_SESSION['role']=="admin"){
                        ?>
                        <li class="nav-item"><a href="admin.php"  data-toggle="tooltip" title="Admin"  class="nav-link"><i class="fa fa-address-card" aria-hidden="true"></i>

                            </a></li>
                        <?php
                    }

                    ?>

                </ul>
            </div>
            <div class="col-2">
                <ul class="navbar-nav float-right">
                    <li class="nav-item active"><a  href="user.php?username=<?php echo $_SESSION['username']; ?>" data-toggle="tooltip" title="My Account"  class="nav-link"><i class="fa fa-user" aria-hidden="true"></i>
                        </a></li>
                    <li class="nav-item"> <a href="logout.php" data-toggle="tooltip" title="Logout" class="nav-link"><i class="fa fa-sign-out" aria-hidden="true"></i>
                        </a> </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
<br/>
<div class="content">
    <div class="row">
        <div class="col-12">
            <center>
                <div class="card" style="width: 25rem;">
                    <div class="card-header">
                        <h3 class="card-title">Edit Profile</h3>
                    </div>
                    <div class="card-body">
                        <form action="" method="post" enctype="multipart/form-data">
                    <ul class="list-group list-group-flush">
                        <?php
                    //ceking bio
                        $username = $_SESSION['username'];
                        $sqluser = "SELECT * FROM user Where username = '$username'";
                        $resultuser = mysqli_query($db,$sqluser);
                        $showuser = mysqli_fetch_array($resultuser);
                        ?>

                        <li class="list-group-item">
                            <p>Username</p>
                            <input class="form-control form-control-sm" type="text" name="username" placeholder="username" value="<?php echo $showuser['username'] ?>">
                        </li>

                        <li class="list-group-item">
                            <p>Picture</p>
                        <input type="file" name="file">
                        </li>
                        <li class="list-group-item">
                            <p>First Name</p>
                            <input class="form-control form-control-sm" type="text" name="fname" placeholder="first name" value="<?php echo $showuser['fname'] ?>">
                        </li>
                        <li class="list-group-item">
                            <p>Last Name</p>
                            <input class="form-control form-control-sm" type="text" name="lname" placeholder="last name" value="<?php echo $showuser['lname'] ?>">
                        </li>

                        <li class="list-group-item">
                            <p>E-Mail</p>
                            <input class="form-control form-control-sm" type="email" name="email" placeholder="Email" value="<?php echo $showuser['email'] ?>">
                        </li>

                        <li class="list-group-item">
                            <p>Bio</p>
                            <input class="form-control form-control-sm" type="text" name="bio" placeholder="Bio" value="<?php echo $showuser['bio'] ?>">
                        </li>


                    </ul>

                        <br>
                        <br>
                        <a href="user.php?username=<?php echo $_SESSION['username']; ?>" class="btn btn-danger card-link">Cancel</a> || <input type="submit" name="submit_edit" value="Save" class="btn btn-success">
                        </form>
                    </div>
                </div>
            </center>
        </div>
    </div>
</div>
