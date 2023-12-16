<?php

    session_start();

    $_SESSION =[];
    setcookie("nama_depan","");
    setcookie("nama_belakang", "");
    setcookie("email", "");

    session_unset();
    session_destroy();

    header("Location: ./../index.php");

?>