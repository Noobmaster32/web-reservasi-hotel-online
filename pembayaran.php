<?php
session_start();
require "./function.php";
if(!isset($_SESSION["login"])){ 
    header('Location: ./login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./dist/output.css">
    <title>Document</title>
</head>
<body >
<header class="relative w-full bg-[#4983D9] shadow-lg">
        <nav class="flex justify-between items-center box-content mx-40 py-2">
            <div class="text-white text-xl font-bold">
                <a href="./index.php">KELOMPOK 11</a>
            </div>
            <div class="flex w-2/3 justify-between items-center">
                <div class="basis-2/3">
                    <ul class="flex justify-end items-center">
                        <!-- <li><a class="text-white py-2 px-4" href="./page/hotelList.php">List Hotel</a></li> -->
                        <?php
                        if (isset($_SESSION["login"]) && isset($_COOKIE["nama_depan"]) && isset($_COOKIE["nama_belakang"])) {
                            echo '<a href="./histpembayaran.php" class="text-white px-4 py-2 hover:bg-slate-600">History Pembayaran</a>';
                        }
                        ?>
                    </ul>
                </div>
                <div class="flex justify-around items-center gap-2">
                    <?php
                    // navbarButton($_SESSION["login"],$_COOKIE["nama_depan"],$_COOKIE["nama_belakang"]);
                    if (isset($_SESSION["login"]) && isset($_COOKIE["nama_depan"]) && isset($_COOKIE["nama_belakang"])) {
                        echo '<div class="text-white px-4 py-2">'.$_COOKIE['nama_depan'].'</div>';
                        echo '<a href="./logout.php" class="text-[#4983D9] bg-[#ffffff] rounded-[calc(8px)] px-4 py-2 hover:bg-slate-600">Log Out</a>';
                    } else {
                        echo '<a href="./signin.php" class="text-[#4983D9] bg-[#ffffff] rounded-[calc(8px)] px-4 py-2 hover:bg-slate-600">Sign In</a>';
                        echo '<a href="./logIn.php" class="text-white border-2 rounded-[calc(8px)] px-4 py-2 hover:bg-slate-600">Log In</a>';
                    }
                    ?>
                </div>
            </div>
        </nav>
    </header>
    <main class="w-full relative">
        <section class="mx-40">
            <div class="text-4xl font-semibold mb-4 pt-8">Contact Details For E-Ticket</div>
            <?php
            if(isset($_SESSION["login"])){
                formPembayaran($_COOKIE['checkin'], $_COOKIE['checkout'], $_COOKIE['nama_hotel'], $_COOKIE['typeRoom'], $_COOKIE['count'], $_COOKIE['email']);
            }
            ?>
        </section>
    </main>
</body>
</html>