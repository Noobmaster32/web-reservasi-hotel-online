<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href=".././dist/output.css">
    <title>Document</title>
</head>

<body class="bg-slate-700">
    <main class="w-full h-full absolute flex justify-center items-center">
        <section class="w-[calc(500px)] h-[calc(600px)] bg-slate-300 rounded-xl">
            <div class="box-content p-8">
                <form class="" action="" method="post">
                    <div class="w-full">
                        <div class="w-full">
                            <div><label for="username">Username or E-mail</label></div>
                            <div><input class="w-full py-2 px-4" type="text" id="username" name="username" placeholder="Ex: John"></div>
                        </div>
                    </div>
                    <div>
                        <div>
                            <label for="password">Password</label>
                        </div>
                        <div>
                            <input class="w-full py-2 px-4" type="password" name="password" id="password" placeholder="Password">
                        </div>
                    </div>
                    <div>
                        <input type="checkbox" name="cookies" id="cookies"><label for="cookies">Remember Me</label>
                    </div>
                    <div>
                        <button type="submit" name="login">Log In</button>
                    </div>
                </form>
            </div>
        </section>
    </main>
</body>
<?php
require './connect.php';
require './function.php';
session_start();

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    login($username,$password);
}
?>

</html>