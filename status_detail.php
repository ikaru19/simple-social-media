<?php

session_start();


if($_SESSION['status']!="login"){
    header("location:login.php");
}
include("config.php");

if (isset($_POST['submit_comment'])) {
    // username and password sent from form
    $id_user = $_SESSION['id'];
    $id_status = $_GET[s_id];
    $comment_content = $_POST['comment'];
    $perintah = $db->query("INSERT INTO comment(id_user, id_status , comment_content) VALUES ('$id_user','$id_status','$comment_content')");

    if ($perintah == true) {
        header("location:status_detail.php?s_id=$id_status");
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
                    <li class="nav-item active"><a href="friend.php" data-toggle="tooltip" title="Friends" class="nav-link"><i class="fa fa-users" aria-hidden="true"></i>
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
            <?php
            $id = $_GET['s_id'];
            $sql = "select s.* , u.* from status s join user u on s.user_id = u.id where s_id = $id";
            $result = mysqli_query($db,$sql);
            $num_rows = mysqli_num_rows($result);
            if ($num_rows > 0) {
               $show = mysqli_fetch_array($result)
                    ?>
                    <div class="card">
                        <div class="card-header">
                            <a href="user.php?username=<?php echo $show['username']; ?>"><?php echo $show['username']; ?> </a>
                        </div>
                        <div class="card-body">
                            <blockquote class="blockquote mb-0">
                                <form action="" method="post" enctype="multipart/form-data">
                                    <!-- Post -->
                                    <div class="post">
                                        <div class="user-block">
                                            <img class="img-circle img-bordered-sm" src="img/<?php echo $show['picture']?>" alt="user image">
                                            <span class="username">
                           <a href="user.php?username=<?php echo $show['username']; ?>"><?php echo $show['username']; ?> </a>

                        </span>

                                        </div>
                                        <!-- /.user-block -->
                                        <p>
                                            <?php echo $show['status_content']; ?>
                                        </p>
                                        <ul class="list-inline">
                                            </li>
                                            <li class="pull-right">
                                                <a href="status_detail.php?s_id=<?php echo $show['s_id']; ?>"
                                                   class="link-black text-sm"><i
                                                        class="fa fa-comments-o margin-r-5"></i> Comments List</a></li>
                                        </ul>

                                        <input class="form-control input-sm" type="text" placeholder="Type a comment" name="comment">
                                        <br>
                                        <input class="form-control input-sm btn btn-info" type="submit" value="Comment" name="submit_comment" >
                                    </div>
                                    <!-- /.post -->
                                </form>

                            </blockquote>
                        </div>
                    </div>
                    <h5>Comment :</h5>
                    <?php
                    $sqlcom = "select c.* , u.username , u.id from comment c join user u on c.id_user = u.id where id_status = $id";
                    $resultcom = mysqli_query($db,$sqlcom);
                    while ($showcom = mysqli_fetch_array($resultcom)){
                    echo '
                        <div class="card">
                            <div class="card-header">
                            
                                <a href="user.php?username='.$showcom['username'].'">
                                    '.$showcom['username'].'
                                </a>';

                    echo '                
                            </div>
                            <div class="card-body">
                                '.$showcom['comment_content'].'
                            </div>
                        </div>
                        <br>
                        ';
                    }

            }else{
                header("location:index.php");
            }

            ?>
        </div>
    </div>
</div>

