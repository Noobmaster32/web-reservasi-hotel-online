<?php
session_start();
require './connect.php';
$hasil_hotel = mysqli_query($conn, "SELECT * FROM hotel");
$hasil_user = mysqli_query($conn, "SELECT * FROM user");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./dist/output.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <title>Reservasi Hotel Online</title>
</head>

<body class="bg-slate-700">
    <div class="w-full h-full fixed -z-10">
        <img class="object-cover w-full h-full" src="./images/banner.webp" alt="banner">
    </div>
    <header class="relative w-full bg-[#4983D9] shadow-2xl">
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
        <section class="h-[calc(600px)]">
            <div class="relative w-full h-full flex items-center justify-center">
                <div class="w-[calc(1200px)] rounded-lg py-8">
                    <h1 class="text-4xl text-center font-bold text-white">Menyediakan Penginapan Hotel, Sesuai Pilihan Mu</h1>
                    <hr class="text-white border-2 mt-6 ">
                    <?php
                        require './function.php';
                        if(isset($_POST['cari'])) {
                            $desc = $_POST['desc'];
                            $checkin = $_POST['checkin'];
                            $checkout = $_POST['checkout'];
                            $count = $_POST['count'];
                            transferCookie($desc, $checkin, $checkout, $count);
                            header('Location: ./hotelList.php');
                            // echo $_COOKIE['desc'];
                        }
                    ?>
                    <form class="flex justify-center items-end mt-8" action="" method="post">
                        <div class="flex">
                            <div class="basis-1/4">
                                <div>
                                    <label class="text-white text-lg" for="desc">Deskripsi Hotel</label>
                                </div>
                                <div>
                                    <input class="w-full h-8 rounded-l-md" type="text" id="desc" name="desc">
                                </div>
                            </div>
                            <div class="basis-1/4">
                                <div>
                                    <label class="text-white text-lg" for="checkin">Check In</label>
                                </div>
                                <div>
                                    <input class="w-full h-8" type="date" id="checkin" name="checkin">
                                </div>
                            </div>
                            <div class="basis-1/4">
                                <div>
                                    <label class="text-white text-lg" for="checkout">Check Out</label>
                                </div>
                                <div>
                                    <input class="w-full h-8" type="date" id="checkout" name="checkout">
                                </div>
                            </div>
                            <div class="basis-1/4">
                                <div>
                                    <label class="text-white text-lg" for="count">Jumlah Kamar</label>
                                </div>
                                <div>
                                    <input class="w-full h-8" type="text" id="count" name="count">
                                </div>
                            </div>
                        </div>
                        <button class="px-4 rounded-r-md h-8 bg-[#4983D9] text-white font-semibold" type="submit" name="cari">Test</button>
                    </form>
                </div>
            </div>
        </section>
        <h1 class='text-2xl italic text-center text-white mb-16'>
            By Kelompok 11
        </h1>
</body>

</html>