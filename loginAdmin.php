<?php
// menyertakan file koneksi database
include "database.php";

// memulai sesi
session_start();

// variabel pesan login
$login_message = "";

// nama cookie untuk menyimpan informasi login
$cookie_name = "logged_in_user";

// jika pengguna sudah login, langsung arahkan ke dashboard
if (isset($_SESSION["is_login"])) {
    header("location: crud.php");
    exit();
}

// mengecek apakah form login sudah dikirim
if (isset($_POST['login'])) {
    // mendapatkan nilai email dan password dari form login
    $email = $_POST['email'];
    $password = $_POST['password'];

    // query untuk mengecek keberadaan email dan password yang cocok di database
    $sql = "SELECT * FROM admin WHERE email='$email' AND password='$password'";

    // menjalankan query dan menyimpan hasilnya dalam variabel $result
    $result = $db->query($sql);

    // mengecek apakah ada baris hasil dari query
    if ($result->num_rows > 0) {
        // mengambil data pengguna dari hasil query
        $data = $result->fetch_assoc();

        // menyimpan email dan menandai pengguna sudah login dalam sesi
        $_SESSION["username"] = $data["email"];
        $_SESSION["is_login"] = true;

        // membuat cookie untuk pengguna yang login dengan durasi 2 jam
        setcookie($cookie_name, $email, time() + (7200), "/");

        // mengarahkan pengguna ke halaman dashboard setelah berhasil login
        header("location: crud.php");
        exit();
    } else {
        // menampilkan pesan jika akun tidak ditemukan
        $login_message = "akun tidak ditemukan";
    }

    // menutup koneksi database
    $db->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('bg 2.png');
            background-size: cover;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background-color: rgba(255, 255, 255, 0.5);
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 1);
            width: 450px;
        }

        .login-container h2 {
            text-align: center;
        }

        .login-container input[type="text"],
        .login-container input[type="password"],
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
            background-color: black;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .login-container input[type="submit"]:hover {
            background-color: black;
            transform: scale(1.05);
        }
    </style>
</head>

<body>

    <div class="login-container">
        <h2>Login</h2>
        <!-- menampilkan pesan login jika ada -->
        <i><?= $login_message ?></i>
        <form action="index.php" method="GET">
            <button type="submit" class="back-button">&larr;</button>
        </form>
        <!-- form login -->
        <form action="loginAdmin.php" method="POST">
            <input type="text" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" name="login" value="LOGIN">
        </form>

    </div>
</body>

</html>