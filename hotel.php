<?php
require './connect.php';
require './function.php';

$id_hotel = $_GET['nama'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./dist/output.css">
    <title>Document</title>
</head>

<body>
    <header class="bg-white w-full py-8">
        <nav class="bg-white box-content mx-40">
            <?php
            if (isset($_COOKIE['desc'])) {
                inputDescHotel($_COOKIE['desc'],$_COOKIE['checkin'],$_COOKIE['checkout'],$_COOKIE['count']);
            }
            ?>
        </nav>
    </header>
    <main class="bg-slate-300">
        <section class="w-full">
            <div class="mx-4 xl:mx-32">
                <?php
                $query = mysqli_query($conn, "SELECT * FROM hotel WHERE nama='$id_hotel'");

                while ($data = mysqli_fetch_array($query)) {
                    echo "<div class='flex justify-between gap-4 pt-16 pb-32'>
                            <div class='basis-5/12'>
                                <img class='w-full h-full object-cover rounded-md shadow-lg' src='./images/image-$data[id].webp' alt='$data[nama]' />
                            </div>
                            <div class='grow basis-6/12 flex flex-col justify-between'>
                                <div>
                                    <div class='text-5xl mb-4 font-bold'>" . $data["nama"] . "</div>
                                    <div class='text-base'>" . $data["desc_hotel"] . "</div>
                                </div>
                                <div class=''>
                                    <div class='text-xl'>" . $data["negara"] . "</div>
                                    <div class='text-xl'>" . $data["provinsi"] . "</div>
                                    <div class='text-xl'>" . $data["kota"] . "</div>
                                </div>
                            </div>
                        </div>";
                }
                ?>
            </div>
        </section>
        <section class="w-full bg-slate-100 py-16 rounded-t-2xl">
            <div class="mx-4 xl:mx-32 box-content">
                <h1 class="text-3xl font-semibold mb-8">List Hotel</h1>
                <?php
                $query2 = mysqli_query($conn, "SELECT * FROM hotel WHERE nama='$id_hotel'");

                while ($datakamar = mysqli_fetch_array($query2)) {
                    typeHotelList($datakamar['id']);
                }
                ?>
            </div>
        </section>
    </main>
</body>

</html>