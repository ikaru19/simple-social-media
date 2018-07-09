<?php
session_start();
if($_SESSION['status']!="login"){
    header("location:login.php");
}

if ($_SESSION['role']!="admin"){
    header("location:index.php");
}
include("config.php");

if (isset($_POST['submit_reg'])) {
    // username and password sent from form

    $username = $_POST['username'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $password = $_POST['password'];
    $email = $_POST['email'];


    $perintah = $db->query("INSERT INTO user(username, password , fname , lname, email , role) VALUES ('$username','$password','$fname','$lname','$email','admin')");

    if ($perintah == true) {
        header("location:admin.php");
    }else{
        printf("Errormessage: %s\n", $db->error);
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
                        <li class="nav-item active"><a href="admin.php"  data-toggle="tooltip" title="Admin"  class="nav-link"><i class="fa fa-address-card" aria-hidden="true"></i>

                            </a></li>
                        <?php
                    }

                    ?>

                </ul>
            </div>
            <div class="col-2">
                <ul class="navbar-nav float-right">
                    <li class="nav-item "><a  href="user.php?username=<?php echo $_SESSION['username']; ?>" data-toggle="tooltip" title="My Account"  class="nav-link"><i class="fa fa-user" aria-hidden="true"></i>
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

                                <li class="list-group-item">
                                    <p>Username</p>
                                    <input class="form-control form-control-sm" type="text" name="username" placeholder="username">
                                </li>
                                <li class="list-group-item">
                                    <p>First Name</p>
                                    <input class="form-control form-control-sm" type="text" name="fname" placeholder="first name" >
                                </li>
                                <li class="list-group-item">
                                    <p>Last Name</p>
                                    <input class="form-control form-control-sm" type="text" name="lname" placeholder="last name" >
                                </li>

                                <li class="list-group-item">
                                    <p>E-Mail</p>
                                    <input class="form-control form-control-sm" type="email" name="email" placeholder="Email" >
                                </li>
                                <li class="list-group-item">
                                    <p>Password</p>
                                    <input class="form-control form-control-sm" type="password" name="password" placeholder="Password" >
                                </li>
                                <li class="list-group-item">
                                    <p>Bio</p>
                                    <input class="form-control form-control-sm" type="text" name="bio" placeholder="Bio" ">
                                </li>


                            </ul>

                            <br>
                            <br>
                            <a href="admin.php" class="btn btn-danger card-link">Cancel</a> || <input type="submit" name="submit_reg" value="Save" class="btn btn-success">
                        </form>
                    </div>
                </div>
            </center>
        </div>
    </div>
</div>

