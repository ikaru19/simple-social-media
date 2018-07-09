<?php
/**
 * Created by PhpStorm.
 * User: ikaru
 * Date: 6/21/18
 * Time: 6:14 PM
 */

// mengaktifkan session
session_start();

// menghapus semua session
session_destroy();

// mengalihkan halaman sambil mengirim pesan logout
header("location:login.php?pesan=logout");