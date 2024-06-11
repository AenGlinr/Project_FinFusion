<?php

//menyertakan file koneksi database
include "database.php";

//memulai sesion
session_start();

//variabel pesan registrasi
$register_message = "";

//nama cookie untuk menyimpan informasi pengguna yang terdaftar
$cookie_name = "registered_user";

//jika pengguna sudah login, langsung arahkan ke dashboard
if (isset($_SESSION["is_login"])) {
    header("location: dashboard.php");
    exit();
}

//mengecek apakah form registrasi sudah dikirim
if (isset($_POST["register"])) {
    //mendapatkan nilai username, password, dan email dari form registrasi
    $username = $_POST["username"];
    $password = $_POST["password"];
    $email = $_POST["email"];

    //mengenkripsi password dengan algoritma SHA-256
    $hash_password = hash("sha256", $password);

    try {
        //query untuk memasukkan data pengguna baru ke dalam database
        $sql = "INSERT INTO user (username, email, password) VALUES ('$username', '$email', '$hash_password')";

        //menjalankan query dan mengecek apakah berhasil
        if ($db->query($sql)) {
            //pesan jika registrasi berhasil
            $register_message = "daftar akun berhasil, silakan login";

            //membuat cookie untuk pengguna yang terdaftar dengan durasi 2 jam
            setcookie($cookie_name, $username, time() + (7200), "/");
        } else {
            //pesan jika terjadi kesalahan saat registrasi
            $register_message = "daftar akun gagal, silakan coba lagi";
        }
    } catch (mysqli_sql_exception) {
        //pesan gagal jika username sudah ada di database
        $register_message = "username sudah ada, silakan ganti yang lain";
    }

    //menutup koneksi database
    $db->close();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('bg 2.jpg');
            background-size: cover;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background-color: whitesmoke;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 1);
            width: 300px;
        }

        .login-container h2 {
            text-align: center;
        }

        .login-container input[type="text"],
        .login-container input[type="password"],
        .login-container input[type="email"],
        .login-container input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            margin-bottom: 10px;
            border: 1px solid black;
            border-radius: 3px;
            box-sizing: border-box;
        }

        .login-container input[type="submit"] {
            background-color: green;
            color: white;
            cursor: pointer;
        }

        .login-container input[type="submit"]:hover {
            background-color: blue;
        }

        h5 {
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="login-container">
        <h2>Create an account</h2>
        <h5>Enter your username, password and email to sign up</h5>
        <i><?= $register_message ?></i>

        <!-- form registrasi -->
        <form action="register.php" method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" name="register" value="SIGN UP">
        </form>
        <h5>By clicking continue, you agree to our Terms of Service and Privacy Policy</h5>
        <a href="index.php">Login</a>

    </div>

</body>

</html>