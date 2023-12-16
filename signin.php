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
        <section class="w-[calc(500px)] h-[calc(600px)] bg-slate-300 rounded-xl overflow-auto">
            <div class="box-content p-8">
                <form class="" action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
                    <div class="flex gap-2">
                        <div>
                            <div><label for="firstName">Nama Depan</label></div>
                            <div><input type="text" id="firstName" name="firstName" placeholder="Ex: John"></div>
                        </div>
                        <div>
                            <div><label for="lastName">Nama Belakang</label></div>
                            <div><input type="text" id="lastName" name="lastName" placeholder="Ex: Doe"></div>
                        </div>
                    </div>
                    <div>
                        <div><label for="username">Username</label></div>
                        <div><input type="text" name="username" id="username"></div>
                    </div>
                    <div>
                        <div>
                            <label for="email">E-mail</label>
                        </div>
                        <div>
                            <input type="email" id="email" name="email">
                        </div>
                    </div>
                    <div>
                        <div>
                            <label for="password">Password</label>
                        </div>
                        <div>
                            <input type="password" name="password" id="password">
                        </div>
                    </div>
                    <div>
                        <div>
                            <label for="passwordCheck">Konfirmasi Password</label>
                        </div>
                        <div>
                            <input type="password" name="passwordCheck" id="passwordCheck">
                        </div>
                    </div>
                    <div>
                        <button type="submit" name="submit">Register</button>
                    </div>
                </form>
            </div>
        </section>
    </main>
</body>

<?php

require './function.php';

if(isset($_POST["submit"])) {
    $nama_depan = $_POST["firstName"];
    $nama_belakang = $_POST["lastName"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $user_password = $_POST["password"];
    $password_confirm = $_POST["passwordCheck"];

    if ($user_password !== $password_confirm) {
        return false;
    }

    $query = "INSERT INTO user (id, username, nama_depan, nama_belakang, email, user_password) VALUES ('', '$username', '$nama_depan', '$nama_belakang', '$email', '$user_password')";
    $hasil = mysqli_query($conn, $query);

    mysqli_affected_rows( $conn );
    header("Location: ./index.php");
}
?>

</html>