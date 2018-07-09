<?php
session_start();


if($_SESSION['status']!="login"){
header("location:login.php");
}

if ($_SESSION['role']!="admin"){
    header("location:index.php");
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
                    <li class="nav-item"><a href="explore.php"  data-toggle="tooltip" title="Explore" class="nav-link"><i class="fa fa-compass" aria-hidden="true"></i>
                        </a></li>
                    <li class="nav-item"><a href="friend.php" data-toggle="tooltip" title="Friends" class="nav-link"><i class="fa fa-users" aria-hidden="true"></i>
                        </a></li>

                    <?php
                    if ($_SESSION['role']=="admin"){
                        ?>
                        <li class="nav-item  active"><a href="admin.php"  data-toggle="tooltip" title="Admin"  class="nav-link"><i class="fa fa-address-card" aria-hidden="true"></i>

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
        <div class="col-6">
            <h2>User</h2>
            <a href="add_admin.php" class="btn btn-primary">Add Admin</a>
            <br>
            <?php
                $sql = "SELECT * FROM user";
                $result = mysqli_query($db,$sql);
                while ($show = mysqli_fetch_array($result)) {
                    ?>
                    <br>
                    <div class="card">
                        <div class="card-header">
                            <div class="post">
                                <?php
                                    if ($show['picture']!=null){
                                        ?>
                                            <div class="user-block">
                                                <img class="img-circle img-bordered-sm" src="img/<?php echo $show['picture']?>" alt="user image">
                                                <span class="username">
                                                   <a href="user.php?username=<?php echo $show['username']; ?>"><?php echo $show['username']; ?> </a>

                                            </span>

                                            </div>
                                <?php

                                    }else{

                                    ?>

                                         <a href="user.php?username=<?php echo $show['username']; ?>"><?php echo $show['username']; ?> </a>
                                <?php
                                    }

                                ?>


                            </div>

                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $show['role']; ?> </h5>
                            <p class="card-text"><?php echo $show['bio']; ?> </p>
                            <?php
                            if ($show['role'] == 'admin'){
                                ?>
                                <a href="edit_profile_admin.php?id=<?php echo $show['id']?>" class="btn btn-primary">Edit</a>
                                <?php
                            }
                            ?>
                            <a href="delete_user.php?id=<?php echo $show['id']?>" class="btn btn-danger">Delete</a>
                            <a href="edit_pass_admin.php?id=<?php echo $show['id']?>" class="btn btn-warning">Change Password</a>
                        </div>
                    </div>

                    <?php
                }
            ?>
        </div>
        <div class="col-6">
            <h2>Status</h2>
            <?php
            $sql = "SELECT * FROM `status` join user on status.user_id = user.id ORDER BY status_time desc ";
            $result = mysqli_query($db,$sql);
            while ($show = mysqli_fetch_array($result)) {
                ?>
                <div class="card">
                    <div class="card-header">
                        <a href="user.php?username=<?php echo $show['username']; ?>"><?php echo $show['username']; ?> </a>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $show['status_time']; ?> </h5>
                        <p class="card-text"><?php echo $show['status_content']; ?> </p>
                        <a href="delete_post_admin.php?id=<?php echo $show['s_id']?>" class="btn btn-danger">Delete</a>

                    </div>
                </div>
                <br>
                <?php
            }
            ?>
        </div>
    </div>

</div>


<center>
    <div id="google_translate_element"></div>

</center>





<script type="text/javascript">
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({pageLanguage: 'en'}, 'google_translate_element');
    }
</script>

<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>



</body>
</html>