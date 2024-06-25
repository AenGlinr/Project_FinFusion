<?php
// menyertakan file koneksi database
include "database.php";

// memulai sesi
session_start();

// nama cookie untuk menyimpan informasi login
$cookie_name = "logged_in_user";

// jika pengguna sudah login, langsung arahkan ke dashboard
if (isset($_SESSION["is_login"])) {
    header("location: dashboard.php");
    exit();
}

// variabel pesan login
$login_message = "";

// mengecek apakah form login sudah dikirim
if (isset($_POST['login'])) {
    // mendapatkan nilai username dan password dari form login
    $username = $_POST['username'];
    $password = $_POST['password'];

    // mengenkripsi password dengan algoritma SHA-256
    $hash_password = hash('sha256', $password);

    // query untuk mengecek keberadaan username dan password yang cocok di database
    $sql = "SELECT * FROM user WHERE username='$username' AND password='$hash_password'";

    // menjalankan query dan menyimpan hasilnya dalam variabel $result
    $result = $db->query($sql);

    // mengecek apakah ada baris hasil dari query
    if ($result->num_rows > 0) {
        // mengambil data pengguna dari hasil query
        $data = $result->fetch_assoc();

        // menyimpan username dan menandai pengguna sudah login dalam sesi
        $_SESSION["username"] = $data["username"];
        $_SESSION["is_login"] = true;

        // membuat cookie untuk pengguna yang login dengan durasi 2 jam
        setcookie($cookie_name, $username, time() + 7200, "/");

        // mengarahkan pengguna ke halaman dashboard setelah berhasil login
        header("location: dashboard.php");
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

        .link-container {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }

        .link-container a {
            /* text-decoration: none;
            color: blue;
            font-size: 14px; */
            display: inline-block;
            /* Membuat elemen inline block agar bisa diatur padding dan margin */
            background-color: black;
            /* Latar belakang hitam */
            color: white;
            /* Teks berwarna putih */
            padding: 10px 20px;
            /* Padding atas/bawah 10px dan kiri/kanan 20px */
            text-decoration: none;
            /* Menghilangkan garis bawah pada teks */
            border-radius: 5px;
            /* Sudut melengkung */
            transition: background-color 0.3s ease, transform 0.3s ease;
            /* Efek transisi untuk perubahan warna dan ukuran */
        }

        .link-container a:hover {
            background-color: black;
            /* Warna latar belakang saat hover */
            transform: scale(1.05);
            /* Membesarkan sedikit saat hover */
        }

        .link-container a:first-child:hover {
            background-color: black;
            /* Warna latar belakang Register saat hover */
        }

        .link-container a:last-child:hover {
            background-color: black;
            /* Warna latar belakang Login Admin saat hover */
        }

        h5 {
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="login-container">
        <h2>Login</h2>
        <!--menampilkan pesan login jika ada -->
        <i><?= $login_message ?></i>

        <h5>Enter your username and password to login for this web</h5>

        <!--form login-->
        <form action="index.php" method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" name="login" value="LOGIN">
        </form>

        <h5>
            <span style="color: grey;">By clicking continue, you agree to our</span> Terms of Service
            <span style="color: grey;">and</span> Privacy Policy
        </h5>

        <div class="link-container">
            <a href="register.php">Register</a>
            <a href="loginAdmin.php">Login Admin</a>
        </div>
    </div>
</body>

</html>