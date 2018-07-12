<?php

    include("config.php");
    session_start();
    if($_SESSION['status']=="login"){
        header("location:index.php");
    }


    if (isset($_POST['submit_reg'])) {
        // username and password sent from form

        $username = $_POST['username'];
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $password = $_POST['password'];
        $email = $_POST['email'];


        $perintah = $db->query("INSERT INTO user(username, password , fname , lname, email , role) VALUES ('$username','$password','$fname','$lname','$email','user')");

        if ($perintah == true) {
            header("location:login.php?pesanreg=berhasil");
        }else{
            printf("Errormessage: %s\n", $db->error);
        }
    }

	if (isset($_POST['submit_login'])) {
   		 // username and password sent from form 
      
      $username = $_POST['username'];

      $password = $_POST['password'];
      $passwordmd = md5($password);

      $sql = "SELECT * FROM user WHERE username = '$username' and password = '$password'";
      $result = mysqli_query($db,$sql);
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
      $active = $row['active'];
      
      $count = mysqli_num_rows($result);
      
      // If result matched $myusername and $mypassword, table row must be 1 row
		
      if($count == 1) {
          $sql = "SELECT role FROM user WHERE username = '$username' and password = '$password'";

          $result = mysqli_query($db,$sql);
          $show = mysqli_fetch_array($result);
          $_SESSION['username'] = $username;
          $_SESSION['id'] = $row['id'];
          $_SESSION['status'] = "login";
          $_SESSION['role'] = $show['role'];
          header("location:index.php");
      }else {
          header("location:login.php?pesan=gagal");

      }
	}




	


?>
<!DOCTYPE html>
<html>
<head>
	<title>Social Media</title>
	<link rel="stylesheet" href="css/bootstrap.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	 <link rel="stylesheet" href="css/style.css">

</head>
<body>
	<header>
		 <nav class="navbar navbar-expand-md navbar-dark " style="background: #1abc9c;">
            <div class="collapse navbar-collapse row">
            	<div class="col-5">
            		<h2 style="color:#fff;" class="float-left">uConnect</h2>
            	</div>
                <div class="col-7">

                	<form action="" class="float-right pr-5" method="post" enctype="multipart/form-data">

                		<table>
                			<tr style="font-size: 12px; color: white;">
                				<td>Username</td>
                				<td>Password</td>
                			</tr>
                			<tr>
                				<td><input class="form-control form-control-sm" type="text" name="username" placeholder="username" required></td>
                				<td><input class="form-control form-control-sm" type="password" name="password" placeholder="password" required></td>
                				<td>	<input type="submit" name="submit_login" value="Login" class="btn btn-success"></td>


                			</tr>

                		</table>
                        <div style = "font-size:11px; color:#cc080c; margin-top:10px;  text-shadow: 0 0 1.5px #ffffff;">
                            <?php
                            if(isset($_GET['pesan'])){
                                if($_GET['pesan'] == "gagal"){
                                    echo "Login gagal! username dan password salah!";
                                }else if($_GET['pesan'] == "logout"){
                                    echo "Anda telah berhasil logout";
                                }else if($_GET['pesan'] == "belum_login"){
                                    echo "Anda harus login untuk mengakses halaman admin";
                                }
                            }
                            ?>
                        </div>
					</form>


                </div>
            </div>
	</header>
	<div class="body">
		<div class="row">
			<div class="col-sm-6 pl-3" align="center">
				 <div class="connect bolder pl-3">
          Connect with friends and the
          world around you on uConnect.</div>
          			  

          			  <div class="leftbar pl-5">
          <i class="fa fa-eye" ></i>
          <div class="fb1">
            <span class="rowtext">See photos and updates</span>
            <span class="rowtext2 fb1">from friends in News Feed</span>
          </div>
        </div> 
          
          <div class="leftbar pl-2">
          	<i class="fa fa-rocket" ></i>
          <div class="fb1">
            <span class="rowtext">Share what's new</span>
            <span class="rowtext2 fb1">in your life on your timeline</span>
            </div>
          </div>
             
            <div class="leftbar pl-5">
            		<i class="fa fa-send" ></i>
          <div class="fb1">
            <span class="rowtext">Find more</span>
            <span class="rowtext2 fb1">of what you're looking for with graph search</span>
        </div> 
        </div> 	
			</div>

			<div class="col-sm-6 " >
				<div id="rightbod" class="m-3">
        <div class="signup bolder">Sign Up</div>
        <div class="free bolder">It's free and always will be</div>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="formbox">
            <input type="text" class="inputbody in1" placeholder="First name" name="fname" required>
            <input type="text" class="inputbody in1 fr" placeholder="Last name" name="lname" required>
            </div>
            <div class="formbox">
            <input type="text" class="inputbody in2" placeholder="Username" name="username" required>
            </div>
            <div class="formbox">
                <input type="text" class="inputbody in2" placeholder="Email" name="email" required>
            </div>
            <div class="formbox">
            <input type="password" class="inputbody in2" placeholder="New password" name="password" required>
            </div>
            <div class="formbox">
                <input type="submit" name="submit_reg" value="sign up" class="signbut bolder" required>
             </div>
        </form>
                    <div style = "font-size:16px; color:#cc2643; margin-top:10px">
                        <?php
                        if(isset($_GET['pesanreg'])){
                            if($_GET['pesanreg'] == "gagal") {
                                echo "Username yang anda masukkan sudah tersedia coba lagi !";
                            }
                        }
                        ?>
                    </div>

                    <div style = "font-size:16px; color:#00cc20; margin-top:10px">
                        <?php
                        if(isset($_GET['pesanreg'])){
                            if($_GET['pesanreg'] == "berhasil") {
                                echo "Registrasi berhasil silahkan login !";
                            }
                        }
                        ?>
                    </div>


                </div>
		</div>
	</div>
	
</body>
</html>