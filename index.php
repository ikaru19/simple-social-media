
<?php

session_start();


if($_SESSION['status']!="login"){
    header("location:login.php");
}
include("config.php");

if (isset($_POST['submit_post'])) {
    // username and password sent from form
    $user_id = $_SESSION['id'];
    $status = $_POST['status'];
    $perintah = $db->query("INSERT INTO status(user_id, status_time , status_content) VALUES ('$user_id',now(),'$status')");

    if ($perintah == true) {
        $username = $_GET[username];

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
                    <li class="nav-item active"><a href="index.php" data-toggle="tooltip" title="Home" class="nav-link"><i class="fa fa-home" aria-hidden="true"></i>
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
                    <li class="nav-item"><a  href="user.php?username=<?php echo $_SESSION['username']; ?>" data-toggle="tooltip" title="My Account"  class="nav-link"><i class="fa fa-user" aria-hidden="true"></i>
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
                    <h4>Make a Post</h4>
                </div>
                <div class="card-body">

                        <form action="" method="post" enctype="multipart/form-data">
                            <!-- Post -->
                            <div class="post">
                               

                                <!-- /.user-block -->
                                <p>
                                    <?php echo $show['status_content']; ?>
                                </p>

                                <input class="form-control input-sm" type="text" name="status" placeholder="What's On Your Mind ?">
                                <br>
                                <input class="form-control input btn btn-info " type="submit" value="Post" name="submit_post">
                            </div>
                            <!-- /.post -->
                        </form>

                </div>
            </div>
            <br>


            <?php
            $id = $_SESSION['id'];
            $sql = "select s.* , f.f_id , u.* from status s join friend f on f.friend_id = s.user_id join user u on u.id = f.friend_id where f.user_id = $id or s.user_id = $id GROUP BY s.s_id ORDER BY s.status_time DESC
";
            $result = mysqli_query($db,$sql);
            $num_rows = mysqli_num_rows($result);
            if ($num_rows > 0) {
                while ($show = mysqli_fetch_array($result)) {
                    ?>
                    <div class="card">
                        <div class="card-header">
                            <!-- Post -->
                            <div class="post">
                                <div class="user-block">
                                    <img class="img-circle img-bordered-sm" src="img/<?php echo $show['picture']?>" alt="user image">
                                    <span class="username">

                           <a href="user.php?username=<?php echo $show['username']; ?>" style="font-size: 1.5em;"><?php echo $show['username']; ?> </a>

                        </span>

                                </div>
                            </div>

                            <?php
                            if ($_SESSION['username'] == $show['username']){
                                ?>


                                <a href="delete_post.php?post=<?php echo $show['s_id'];?>" class="text-sm float-right ml-2  btn btn-danger">delete&nbsp;</a>
                                &nbsp;
                                <a href="edit_post.php?post=<?php echo $show['s_id'];?>" class="text-sm float-right btn btn-info ml-2 ">edit</a>
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
                                        <p>
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

                ?>
                <div class="card">
                    <div class="card-body">
                        Get Some Friend
                        <a href="explore.php">here</a>
                    </div>
                </div>
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
        new google.translate.TranslateElement({pageLanguage: 'id'}, 'google_translate_element');
    }
</script>

<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>






</body>
</html>