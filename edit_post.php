<?php
session_start();
include("config.php");

if($_SESSION['status']!="login"){
    header("location:login.php");
}
//cek user pemilik post
$id = $_GET[post];
$sqlpost = "SELECT * FROM status Where s_id = $id";
$resultpost = mysqli_query($db,$sqlpost);
$showpost = mysqli_fetch_array($resultpost);

if ($_SESSION['id']!=$showpost['user_id']){
    header("location:index.php");
}

if (isset($_POST['submit_post'])) {
    $id = $_GET[post];
    $status = $_POST['status'];

    $perintah = $db->query("UPDATE status SET status_content ='$status' WHERE s_id='$id'");

    if ($perintah == true) {
        $username = $_SESSION['username'];

        header("location:user.php?username=$username");
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
                    <li class="nav-item"><a href="index.php" data-toggle="tooltip" title="Home" class="nav-link"><i class="fa fa-home" aria-hidden="true"></i>
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
                    <li class="nav-item  active "><a  href="user.php?username=<?php echo $_SESSION['username']; ?>" data-toggle="tooltip" title="My Account"  class="nav-link"><i class="fa fa-user" aria-hidden="true"></i>
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

            <div class="card">
                <div class="card-header">
                    <h4>Edit Post</h4>
                </div>
                <div class="card-body">

                    <form action="" method="post" enctype="multipart/form-data">
                        <!-- Post -->
                        <div class="post">
                            <?php
                            //ceking post
                            $id = $_GET[post];
                            $sqlpost = "SELECT * FROM status Where s_id = $id";
                            $resultpost = mysqli_query($db,$sqlpost);
                            $showpost = mysqli_fetch_array($resultpost);
                        ?>

                            <input class="form-control input-sm" type="text" name="status" placeholder="What's On Your Mind ?" value="<?php echo $showpost['status_content'] ?>">
                            <br>
                            <input class="form-control input btn btn-info " type="submit" value="Post" name="submit_post">
                        </div>
                        <!-- /.post -->
                    </form>

                </div>
            </div>
            <br>
        </div>
    </div>
</div>


</body>
</html>
