<?php
// Memulai sesi atau melanjutkan sesi yang sudah ada
session_start();

// Mengecek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    // Mengarahkan pengguna ke halaman login jika belum login
    header('location: loginAdmin.php');
    exit();
}

// Proses logout
if (isset($_POST['logout'])) {
    // Menghapus semua variabel sesi
    session_unset();
    // Menghancurkan sesi
    session_destroy();
    // Mengarahkan pengguna ke halaman loginAdmin.php setelah logout
    header('location: loginAdmin.php');
    exit();
}

// Menampilkan semua kesalahan PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Halaman dengan Sidebar Tetap</title>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
            background: url('bg 1.png') no-repeat center center;
            background-size: cover;
            position: relative;
        }
        .sidebar {
            box-sizing: border-box;
            position: fixed;
            width: 256px;
            height: 100vh;
            left: 0;
            top: 0;
            background: url('bg 1.png') no-repeat center center;
            background-size: cover;
            border-right: 1px solid #E0E0E0;
            padding: 20px;
        }
        .sidebar h3 {
            font-weight: 600;
            font-size: 20px;
            line-height: 30px;
            letter-spacing: -0.01em;
            color: #000000;
            margin-bottom: 20px;
        }
        .sidebar ul {
            list-style: none;
            padding: 0;
        }
        .sidebar ul li {
            margin-bottom: 16px;
        }
        .sidebar ul li a {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: #000000;
            padding: 10px 16px;
            background: #FFFFFF;
            border-radius: 8px;
            transition: background 0.3s;
        }
        .sidebar ul li a:hover {
            background: #F7F7F7;
        }
        .sidebar ul li a i {
            margin-right: 8px;
        }
        .sidebar .list-title-style {
            display: flex;
            align-items: center;
            font-weight: 600;
            font-size: 16px;
            color: #000000;
            margin-bottom: 8px;
        }
        .sidebar .list-title-style i {
            margin-right: 8px;
        }
        .sidebar ul ul {
            padding-left: 16px;
        }
        .content {
            flex: 1;
            padding: 20px;
            margin-left: 256px;
            background: url('bg 1.png') no-repeat center center;
        }
        .content h1 {
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 20px;
            color: #333;
        }
        .content h2 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 10px;
            color: #333;
        }
        .content p {
            line-height: 1.6;
            color: #555;
        }
        .card-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .card {
            width: 262px;
            height: 350px; 
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .card img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 10px;
        }
        .card h3 {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 5px;
            color: #333;
        }
        .card p {
            font-size: 1rem;
            line-height: 1.5;
            color: #555;
        }
        .card .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border-radius: 8px;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .card .button:hover {
            background-color: #0056b3;
        }
        .call-to-action {
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
        }
        .call-to-action button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .call-to-action button:hover {
            background-color: #0056b3;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        .header h2 {
            font-size: 1.5rem;
            font-weight: 600;
            color: #333;
            margin: 0;
        }
        .card-content {
            display: flex;
            flex-direction: column;
        }
        .card-content .graphic {
            width: 100%;
            height: 200px;
            background-color: #eee;
            border-radius: 8px;
            margin-bottom: 10px;
            background-size: cover;
        }
        .card-content .copy {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .card-content .subtitle {
            font-size: 1rem;
            font-weight: 500;
            color: #333;
        }
        .card-content .description {
            font-size: 0.9rem;
            line-height: 1.5;
            color: #555;
        }
        .card-content .button-container {
            display: flex;
            justify-content: center;
            margin-top: 5px;
        }
        .card-content .button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .card-content .button:hover {
            background-color: #0056b3;
        }
        .card-title {
            grid-column: 1 / -1;
            font-size: 1.5rem;
            font-weight: 600;
            color: #333;
            margin-top: 20px;
        }
        .profile-container {
            background-color: whitesmoke;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            width: 200px;
            text-align: center;
            position: fixed;
            bottom: 10px;
            left: 10px;
        }
        .profile-image {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
        }
        .username {
            font-size: 24px;
            color: black;
            margin-top: -10px;
            margin-bottom: 20px;
        }
        .logout-button {
            width: 100%;
            padding: 10px;
            background-color: green;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .logout-button:hover {
            background-color: red;
        }
        .back-button {
            position: absolute;
            top: 10px;
            left: 10px;
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h3>Finfusion App</h3>
        <ul>
            <li><a href="#"><i class="fas fa-search"></i> Browse</a></li>
            <li><a href="#"><i class="fas fa-shopping-cart"></i> Keranjang</a></li>
        </ul>
    </div>
    <div class="content">
        <h1>Home</h1>
        <div class="header">
            <h2>Ikan Cupang</h2>
        </div>
        <div class="card-container">
            <!-- Ikan Cupang -->
            <div class="card">
                <div class="card-content">
                    <div class="graphic" style="background-image: url('img/veiltail_cupang.jpg')"></div>
                    <div class="copy">
                        <h3 class="subtitle">Velitail</h3>
                        <p class="description">Description of playlist</p>
                    </div>
                    <div class="button-container">
                        <button class="button">Detail</button>
                    </div>
                </div>
            </div>
            <!-- Halfsun -->
            <div class="card">
                <div class="card-content">
                    <div class="graphic" style="background-image: url('img/halfsun_cupang.jpg')"></div>
                    <div class="copy">
                        <h3 class="subtitle">Halfsun</h3>
                        <p class="description">Description of playlist</p>
                    </div>
                    <div class="button-container">
                        <button class="button">Detail</button>
                    </div>
                </div>
            </div>
            <!-- Plakat -->
            <div class="card">
                <div class="card-content">
                    <div class="graphic" style="background-image: url('img/plakat_cupang.jpg')"></div>
                    <div class="copy">
                        <h3 class="subtitle">Plakat</h3>
                        <p class="description">Description of playlist</p>
                    </div>
                    <div class="button-container">
                        <button class="button">Detail</button>
                    </div>
                </div>
            </div>
            <!-- Halfmoon -->
            <div class="card">
                <div class="card-content">
                    <div class="graphic" style="background-image: url('img/halfmoon_cupang.jpg')"></div>
                    <div class="copy">
                        <h3 class="subtitle">Halfmoon</h3>
                        <p class="description">Description of playlist</p>
                    </div>
                    <div class="button-container">
                        <button class="button">Detail</button>
                    </div>
                </div>
            </div>

            <div class="card-title">Ikan Koi</div>
            <!-- Ikan Koi -->
            <div class="card">
                <div class="card-content">
                    <div class="graphic" style="background-image: url('img/chagoi.jpg')"></div>
                    <div class="copy">
                        <h3 class="subtitle">Chagoi</h3>
                        <p class="description">Description of playlist</p>
                    </div>
                    <div class="button-container">
                        <button class="button">Detail</button>
                    </div>
                </div>
            </div>
            <!-- Tancho -->
            <div class="card">
                <div class="card-content">
                    <div class="graphic" style="background-image: url('img/Tancho.jpg')"></div>
                    <div class="copy">
                        <h3 class="subtitle">Tancho</h3>
                        <p class="description">Description of playlist</p>
                    </div>
                    <div class="button-container">
                        <button class="button">Detail</button>
                    </div>
                </div>
            </div>
            <!-- Shiro Utsuri -->
            <div class="card">
                <div class="card-content">
                    <div class="graphic" style="background-image: url('img/shiro.jpeg')"></div>
                    <div class="copy">
                        <h3 class="subtitle">Shiro Utsuri</h3>
                        <p class="description">Description of playlist</p>
                    </div>
                    <div class="button-container">
                        <button class="button">Detail</button>
                    </div>
                </div>
            </div>
            <!-- Ochiba Shigure -->
            <div class="card">
                <div class="card-content">
                    <div class="graphic" style="background-image: url('img/ochi.jpeg')"></div>
                    <div class="copy">
                        <h3 class="subtitle">Ochiba Shigure</h3>
                        <p class="description">Description of playlist</p>
                    </div>
                    <div class="button-container">
                        <button class="button">Detail</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="call-to-action">
            <button>Call to action</button>
        </div>
    </div>
    <div class="profile-container">
        <img src="profile.png" alt="Profile Image" class="profile-image">
        <h2 class="username"><?= htmlspecialchars($_SESSION["username"]) ?></h2>
        <form action="crud.php" method="POST">
            <input type="submit" name="logout" value="Logout" class="logout-button">
        </form>
    </div>
</body>
</html>
