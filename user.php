<?php
session_start();

if($_SESSION['status']!="login"){
    header("location:login.php");
}
include("config.php");

//ceking profile
$username = $_GET[username];
$sqlcekprofile = "SELECT * FROM user Where username = '$username'";
$resultcekprofile = mysqli_query($db,$sqlcekprofile);
$showcekprofile = mysqli_fetch_array($resultcekprofile);
$num_rows = mysqli_num_rows($resultcekprofile);
if ($num_rows==0){
    header("location:index.php");
}
$id = $_SESSION['id'];


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
                    <?php
                    if ($_SESSION['username'] == $_GET[username]){
                        ?>
                        <li class="nav-item"><a href="friend.php"  data-toggle="tooltip" title="Friends" class="nav-link"><i class="fa fa-users" aria-hidden="true"></i>
                            </a></li>
                        <?php
                    }else{
                        ?>
                        <li class="nav-item active"><a href="friend.php"  data-toggle="tooltip" title="Friends" class="nav-link"><i class="fa fa-users" aria-hidden="true"></i>
                            </a></li>
                        <?php
                    }
                    ?>


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
                    <?php
                     if ($_SESSION['username'] == $_GET[username]){
                         ?>
                    <li class="nav-item active"><a  href="user.php?username=<?php echo $_SESSION['username']; ?>" data-toggle="tooltip" title="My Account"  class="nav-link"><i class="fa fa-user" aria-hidden="true"></i>
                        </a></li>
                    <?php
                     }else{
                         ?>
                         <li class="nav-item"><a  href="user.php?username=<?php echo $_SESSION['username']; ?>" data-toggle="tooltip" title="My Account"  class="nav-link"><i class="fa fa-user" aria-hidden="true"></i>
                             </a></li>
                    <?php
                     }
                    ?>

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
        <div class="col-3">
            <!-- Profile Image -->
            <?php
                    //ceking bio
                        $username = $_GET[username];
                        $sqluser = "SELECT * FROM user Where username = '$username'";
                        $resultuser = mysqli_query($db,$sqluser);
                        $showuser = mysqli_fetch_array($resultuser);
                        ?>

            <div class="box box-primary">
                <div class="box-body box-profile">
                    <?php
                    if ($showuser['picture']!=null){
                        ?>
                        <center>
                    <img class="profile-user-img img-responsive img-circle" src="img/<?php echo $showuser['picture']?>" alt="User profile picture">
                    </center>
                    <?php
                    }
                    ?>
                    <h2 class="profile-username text-center">
                        <?php
                            echo $_GET[username];
                            echo ' ';
                            if ($showuser['role']==admin){
                                echo '<i class="fa fa-check-circle " data-toggle="tooltip" title="Admin" aria-hidden="true"> </i>';
                            }
                        ?>
                    </h2>
                  <?php
                        if ($_SESSION['username'] == $_GET[username]){

                            echo  '<h5 class="text-muted text-center">('.$showuser['fname'].' '.$showuser['lname'].')</h5>';
                            echo  '<p class="text-muted text-center">'.$showuser['bio'].'</p>';
                            echo '  <a href="edit_profile.php" class="btn btn-info btn-block"><b>Edit Profile</b></a>';
                        }else{
                            echo  '<h5 class="text-muted text-center">('.$showuser['fname'].' '.$showuser['lname'].')</h5>';
                            echo '<p class="text-muted text-center">' . $showuser['bio'] . '</p>';
                            //cek follow

                            $sqlfollow = "select u.username from user u join friend f on f.friend_id = u.id where f.user_id = $id and u.username = '$username'";
                            $resultfollow = mysqli_query($db,$sqlfollow);
                            $showfollow = mysqli_fetch_array($resultfollow);
                            $hasil = mysqli_num_rows($resultfollow);

                            if ($hasil > 0){
                                echo '  <a href="unfollow.php?username=' . $showuser['id'] . '" class="btn btn-danger btn-block"><b>Unfollow</b></a>';
                            }else {
                                echo '  <a href="follow.php?username=' . $showuser['id'] . '" class="btn btn-primary btn-block"><b>Follow</b></a>';
                            }
                        }
                    ?>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <div class="col-9">
            <?php
            //ceking status

            $sql = "select u.id , u.username , s.* from user u join status s on s.user_id = u.id where u.username = '$_GET[username]' order by s.status_time DESC";
            $result = mysqli_query($db,$sql);
            $num_rows = mysqli_num_rows($result);
            if ($num_rows > 0) {
                while ($show = mysqli_fetch_array($result)) {
                    ?>
                    <div class="card">
                        <div class="card-header">
                           <a href="user.php?username=<?php echo $show['username']; ?>" style="font-size: 1.35em"><?php echo $show['username']; ?> </a>
                            <?php
                                if ($_SESSION['username'] == $_GET[username]){
                                        ?>


                                            <a href="delete_post.php?post=<?php echo $show['s_id'];?>" class="float-right ml-2  btn btn-danger">delete&nbsp;</a>
                                            &nbsp;
                                            <a href="edit_post.php?post=<?php echo $show['s_id'];?>" class=" float-right btn btn-info ml-2 ">edit</a>
                                        <?php
                                }

                            ?>
                        </div>
                        <div class="card-body">
                            <blockquote class="blockquote mb-0">
                                <form action="" method="post" enctype="multipart/form-data">
                                    <!-- Post -->
                                    <div class="post">


                                                                                <!-- /.user-block -->
                                        <p style="font-size: 1.35em">
                                            <?php echo $show['status_content']; ?>
                                        </p>
                                        <ul class="list-inline">
                                            </li>
                                            <li class="pull-right">
                                                <a href="status_detail.php?s_id=<?php echo $show['s_id']; ?>"
                                                   class="text-sm btn btn-info">See More</a></li>
                                        </ul>
                                    </div>
                                    <!-- /.post -->
                                </form>
                            </blockquote>
                        </div>
                    </div>
                    <br>
                    <?php
                }
            }else{
                if ($_SESSION['username'] == $_GET[username]) {
                    ?>
                    <div class="card">
                        <div class="card-body">
                            No Post To Display , Post
                            <a href="index.php">here</a>
                        </div>
                    </div>
                    <?php
                }else{
                    ?>
                    <div class="card">
                        <div class="card-body">
                            No Post To Display
                        </div>
                    </div>
                    <?php
                }
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