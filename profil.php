<?php
// Memulai sesi atau melanjutkan sesi yang sudah ada
session_start();

// Mengecek apakah ada permintaan logout yang dikirim melalui metode POST
if (isset($_POST['logout'])) {
    // Menghapus semua variabel sesi
    session_unset();
    // Menghancurkan sesi
    session_destroy();
    // Mengarahkan pengguna ke halaman index.php setelah logout
    header('location: index.php');
    // Menghentikan eksekusi skrip untuk memastikan header() berfungsi dengan benar
    exit();
}

// Mengecek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    // Jika pengguna belum login, arahkan ke halaman login
    header('location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('bg 1.png');
            background-size: cover;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            position: relative;
        }

        .profile-container {
            background-color: whitesmoke;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            width: 300px;
            text-align: center;
        }

        .profile-image {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
            /* Mengurangi margin bawah gambar */
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
    <form action="dashboard.php" method="GET">
        <button type="submit" class="back-button">&larr;</button>
    </form>
    <div class="profile-container">
        <img src="profile.png" alt="Profile Image" class="profile-image">
        <h2 class="username"><?= htmlspecialchars($_SESSION["username"]) ?></h2>
        <form action="profil.php" method="POST">
            <input type="submit" name="logout" value="Logout" class="logout-button">
        </form>
    </div>
</body>

</html>
