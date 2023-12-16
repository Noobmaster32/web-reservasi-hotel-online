<?php
    require "./connect.php";
    $id = $_GET["id"];
    $result = mysqli_query($conn, "DELETE FROM pemesanan WHERE id='$id'");
    header("Location: ./histpembayaran.php");
?>