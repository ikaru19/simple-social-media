<?php
session_start();


if($_SESSION['status']!="login"){
    header("location:login.php");
}
include("config.php");

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
                    <li class="nav-item active"><a href="explore.php"  data-toggle="tooltip" title="Explore" class="nav-link"><i class="fa fa-compass" aria-hidden="true"></i>
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
                    <li class="nav-item"><a  href="user.php?username=<?php echo $_SESSION['username']; ?>" data-toggle="tooltip" title="My Account"  class="nav-link"><i class="fa fa-user" aria-hidden="true"></i>
                        </a></li>
                    <li class="nav-item"> <a href="logout.php" data-toggle="tooltip" title="Logout" class="nav-link"><i class="fa fa-sign-out" aria-hidden="true"></i>
                        </a> </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
<div class="content">
    <div class="row">
        <div class="col-12">
            <center>
            <?php
            $id = $_SESSION['id'];
            $sql = "SELECT * FROM user WHERE id NOT IN (SELECT friend_id FROM friend Where user_id = $id) AND  id <> $id";
            $result = mysqli_query($db,$sql);
            $num_rows = mysqli_num_rows($result);
            if ($num_rows > 0) {
                while ($show = mysqli_fetch_array($result)) {
                    ?>
                    <div class="card w-50">
                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="user.php?username=<?php echo $show['username']; ?>"><?php echo $show['username']; ?> </a>
                            </h5>

                            <p class="card-text"><?php echo $show['bio'] ?></p>
                            <a href="follow.php?username=<?php echo $show['id']; ?>"
                               class="btn btn-primary float-right ml-2">Follow</a>
                        </div>
                    </div>
                    <br>
                    <?php
                }
            }else
                echo ' <div class="card">
                        <div class="card-body">
                            Nothing To See Here
                        </div>
                    </div>';
            ?>
            </center>
        </div>
    </div>
</div>

</body>
</html>
