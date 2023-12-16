<?php
require './function.php';
session_start();

if (!isset($_COOKIE['desc'])) {
    header('Location: ./index.php');
}
if (!isset($_COOKIE['checkin'])) {
    header('Location: ./index.php');
}
if (!isset($_COOKIE['checkout'])) {
    header('Location: ./index.php');
}
if (!isset($_COOKIE['count'])) {
    header('Location: ./index.php');
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

<body class="bg-slate-200">
    <header class="bg-white w-full py-8">
        <nav class="bg-white box-content mx-40">
            <?php
            if (isset($_COOKIE['desc'])) {
                inputDescHotel($_COOKIE['desc'],$_COOKIE['checkin'],$_COOKIE['checkout'],$_COOKIE['count']);
            }
            ?>
        </nav>
    </header>
    <main class="w-full h-full py-12">
        <div class="flex w-full h-full px-20">
            <section class="w-full">
                <div class="">
                    <?php
                    if (isset($_COOKIE['desc'])) {
                        $data = cariToList($_COOKIE['desc']);
                        listHotels($data);
                    }
                    ?>
                </div>
            </section>
        </div>
    </main>
</body>

</html>