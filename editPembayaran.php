<?php
require './connect.php';
require './function.php';
session_start();
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
    <main class="w-full mt-12">
        <section class="mx-40">
            <div>
                <?php
                    editPemesanan($_COOKIE['checkin'], $_COOKIE['checkout'], $_COOKIE['count']);
                ?>
            </div>
        </section>
    </main>
</body>
</html>